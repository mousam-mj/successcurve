<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    private $filters;

    public function  __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = User::select('id', 'name', 'email', 'contact', 'type', 'userStatus', 'created_at');
        
        // Apply filters
        if (isset($this->filters['type']) && $this->filters['type'] != '') {
            $query->where('type', $this->filters['type']);
        }
        
        if (isset($this->filters['status']) && $this->filters['status'] != '') {
            if ($this->filters['status'] == 'active') {
                $query->where('userStatus', '!=', 2);
            } elseif ($this->filters['status'] == 'banned') {
                $query->where('userStatus', 2);
            }
        }
        
        if (isset($this->filters['search']) && $this->filters['search'] != '') {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                  ->orWhere('email', 'like', '%'.$search.'%')
                  ->orWhere('contact', 'like', '%'.$search.'%');
            });
        }
        
        return $query->get()->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'contact' => $user->contact,
                'type' => $user->type,
                'status' => $user->userStatus == 2 ? 'Banned' : 'Active',
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'User ID',
            'Name',
            'Email',
            'Phone',
            'Type',
            'Status',
            'Created At'
        ];
    }

}
