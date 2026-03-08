<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Base query for non-admin customers (reusable).
     */
    private function customersQuery(?string $search = null)
    {
        $search = trim((string) $search);

        return User::query()
            ->where('is_admin', 0)
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%")
                       ->orWhere('phone', 'like', "%{$search}%");
                });
            });
    }

    public function index(Request $request)
    {
        $search = (string) $request->get('search', '');
        $perPage = (int) $request->get('per_page', 10);

        // prevent weird values
        if ($perPage < 5) $perPage = 5;
        if ($perPage > 100) $perPage = 100;

        $customers = $this->customersQuery($search)
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();

        // total matching records (not just current page)
        $totalCustomers = $customers->total();

        return view('admin.customers.index', compact(
            'customers',
            'search',
            'perPage',
            'totalCustomers'
        ));
    }

    public function show($id)
    {
        $customer = $this->customersQuery()
            ->findOrFail($id);

        return view('admin.customers.show', compact('customer'));
    }

    public function destroy($id)
    {
        $customer = $this->customersQuery()
            ->findOrFail($id);

        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}