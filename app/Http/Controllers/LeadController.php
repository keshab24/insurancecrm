<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Event;
use App\Models\LeadSource;
use App\Models\Meeting;
use App\Models\LeadType;
use App\Models\Province;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use App\Models\PolicySubCategory;
use App\Models\PolicyType;
use App\Models\Remark;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public $selectedClass = null;
    public $selectedSection = null;
    public $sections = null;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['lead_sources'] = LeadSource::where('is_active', '=', '1')->get();
        $data['lead_types'] = LeadType::where('is_active', '=', '1')->get();
        $data['provinces'] = Province::all();
        $data['cities'] = City::all();
        $data['policy_categories'] = DB::table('policy_categories')->get();
        $data['policy_sub_categories'] = PolicySubCategory::where('is_active', '1')->get();
        $data['policy_types'] = PolicyType::where('is_active', '1')->get();
        $data['remarks'] = Remark::first();
        $data['users'] = User::whereNotIn('username', ['superadmin', 'admin'])->get();
        if (Auth::user()->role_id == 1) {
            $data['leads'] = Lead::latest()->paginate(20);
        } else {
            $data['leads'] = Lead::where('sales_person_name', '=', Auth::user()->username)->paginate(20);
        }
        if ($request->search) {
            $data['leads'] = Lead::where('is_user', '1')
                ->where(function ($query) use ($request) {
                    $query->where('customer_name', 'like', '%' . $request->search . '%')
                        ->orWhere('lead_id', 'like', '%' . $request->search . '%')
                        ->orWhere('phone', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%')
                        ->orWhere('id', 'like', '%' . $request->search . '%');
                })->paginate(20);

        }
        return view('Backend.Leads.AllLeads.leads', $data);
    }

    public function customersList(Request $request)
    {
        $data['lead_sources'] = LeadSource::where('is_active', '=', '1')->get();
        $data['lead_types'] = LeadType::where('is_active', '=', '1')->get();
        $data['provinces'] = Province::all();
        $data['cities'] = City::all();
        $data['policy_categories'] = DB::table('policy_categories')->get();
        $data['policy_sub_categories'] = PolicySubCategory::where('is_active', '1')->get();
        $data['policy_types'] = PolicyType::where('is_active', '1')->get();
        $data['remarks'] = Remark::first();
        $data['users'] = User::whereNotIn('username', ['superadmin', 'admin'])->get();
        if (Auth::user()->role_id == 1) {
            $leads = Lead::where('is_user', '1');
        } else {
            $leads = Lead::where('sales_person_name', '=', Auth::user()->username)->where('is_user', '1');
        }
        if ($request->search) {
            $leads = $leads->where(function ($query) use ($request) {
                $query->where('customer_name', 'like', '%' . $request->search . '%')
                    ->orWhere('lead_id', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('id', 'like', '%' . $request->search . '%');
            });
        }
//        dd($leads->get());
        $data['leads'] = $leads->paginate(20);
        return view('Backend.Leads.AllLeads.customers', $data);
    }


    public function getCityList($id)
    {
        echo json_encode(DB::table('cities')->where('province_id', $id)->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return $request;
        $validatedData = $request->validate([
            'sales_person_name' => ['required', 'max:255'],
            'customer_name' => ['required'],
        ]);
        $destinationpath = 'uploads/leads/';

        $data = $request->except('_token', 'policy_doc', 'identity_doc');

        $imageFilep = $request->policy_doc;
        $imageFilei = $request->identity_doc;
        // dd($imageFilep);
        if ($imageFilep) {
            $extension = strrchr($imageFilep->getClientOriginalName(), '.');
            $new_file_name = "Leadpolicy_" . time();
            $policy_doc = $imageFilep->move($destinationpath, $new_file_name . $extension);
            $data['policy_doc'] = isset($policy_doc) ? $new_file_name . $extension : NULL;
        }
        if ($imageFilei) {
            $extension = strrchr($imageFilei->getClientOriginalName(), '.');
            $new_file_name = "Leadidentity_" . time();
            $identity_doc = $imageFilei->move($destinationpath, $new_file_name . $extension);
            $data['identity_doc'] = isset($identity_doc) ? $new_file_name . $extension : NULL;
        }
        // dd($data);
        $leads = Lead::create($data);
        if ($leads) {
            return redirect()->back()->withSuccessMessage('Customer is added successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('Customer can not be created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $lead_sources = LeadSource::where('is_active', '=', '1')->get();
        $lead_types = LeadType::where('is_active', '=', '1')->get();
        $provinces = Province::all();
        $policy_categories = DB::table('policy_categories')->get();
        $policy_sub_categories = PolicySubCategory::where('is_active', '1')->get();
        $policy_types = PolicyType::where('is_active', '1')->get();
        $lead = Lead::findorfail($request->lead);
        return view('Backend.Leads.Leads.edit', compact('lead', 'lead_sources', 'lead_types', 'provinces', 'policy_categories', 'policy_sub_categories', 'policy_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $destinationpath = 'uploads/leads/';

        $validatedData = $request->validate([
            'sales_person_name' => ['required', 'max:255'],
            'customer_name' => ['required'],
//            'policy_type' => ['required']
        ]);

        $data = $request->except('_token', '_method', 'lead_id', 'policy_doc', 'identity_doc');

        $imageFilep = $request->policy_doc;
        $imageFilei = $request->identity_doc;
        // dd($imageFilep);
        if ($imageFilep) {
            $extension = strrchr($imageFilep->getClientOriginalName(), '.');
            $new_file_name = "Leadpolicy_" . time();
            $policy_doc = $imageFilep->move($destinationpath, $new_file_name . $extension);
            $data['policy_doc'] = isset($policy_doc) ? $new_file_name . $extension : NULL;
        }
        if ($imageFilei) {
            $extension = strrchr($imageFilei->getClientOriginalName(), '.');
            $new_file_name = "Leadidentity_" . time();
            $identity_doc = $imageFilei->move($destinationpath, $new_file_name . $extension);
            $data['identity_doc'] = isset($identity_doc) ? $new_file_name . $extension : NULL;
        }

        $leads = Lead::where('id', $request->lead_id)->update($data);
        if ($leads) {
            return redirect()->route('admin.leads.index')->withSuccessMessage('Leads is updated successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('Leads Can not be updated.');
    }

    public function makeUser(request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flag = Lead::destroy($id);

        if ($flag) {
            return response()->json([
                'type' => 'success',
                'message' => 'Lead is deleted successfully.'
            ], 200);
        }
        return response()->json([
            'type' => 'error',
            'message' => 'Lead can not be deleted.'
        ], 422);
    }

    public function delete($id)
    {
        return $flag = Lead::findOrfail($id);
        $flag->delete($id);
        if ($flag) {
            return redirect()->route('admin.leads.index')->withSuccessMessage('Leads is deleted successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('Leads can not be deleted.');
    }

    public function show($id)
    {
        $leads = Lead::all();
        $lead = Lead::findOrfail($id);
        return view('Backend.Leads.Leads.show', compact('leads', 'lead'));

    }

    public function remark(Request $request)
    {
        $data = $request->except('_token');
        $remark = Event::create($data);


        if ($remark) {
            return redirect()->route('admin.leads.index')->withSuccessMessage('Remark is added successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('Remark can not be created.');
    }

    public function meeting(Request $request)
    {
        $data = $request->except('_token');
        $remark = Meeting::create($data);


        if ($remark) {
            return redirect()->route('admin.leads.index')->withSuccessMessage('Meeting is scheduled successfully.');
        }
        return redirect()->back()->withInput()->withWarningMessage('Meeting can not be created.');
    }

    public function GetRemarkList(Request $request, $id)
    {
        $remarks = Event::where('lead_id', $id)->get();
        return view('Backend.Leads.Leads._remarkslist', compact('remarks'));
    }

    public function GetMeetingList(Request $request, $id)
    {
        $remarks = Meeting::where('lead_id', $id)->get();
        return view('Backend.Leads.Leads._meetingslist', compact('remarks'));
    }


    public function getAjax()
    {
        $id = $_GET['id'];
        $remark = Remark::where('lead_id', $id)->get();


        foreach ($remark as $row) {
            $html =
                '<tr>
                        <td>' . $row->remark . '</td>' .
                '<td>' . $row->created_by . '</td>' .
                '<td>' . $row->id . '</td>' .
                '</tr>';
        }
        return $html;
    }
}
