<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipPlan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index() {
        return MembershipPlan::all();
    }

    public function store(Request $request) {
        $plan = MembershipPlan::create($request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'duration_days' => 'required|integer'
        ]));
        return response()->json($plan, 201);
    }

    public function show(MembershipPlan $plan) {
        return $plan;
    }

    public function update(Request $request, MembershipPlan $plan) {
        $plan->update($request->all());
        return $plan;
    }

    public function destroy(MembershipPlan $plan) {
        $plan->delete();
        return response()->noContent();
    }
}
