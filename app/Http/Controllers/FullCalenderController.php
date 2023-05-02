<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Meeting;



class FullCalenderController extends Controller
{
    public function index(Request $request)
    {
    	if($request->ajax())
    	{
    		$data = Event::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->get(['id', 'title', 'start', 'end']);
            return response()->json($data);
    	}
    	return view('full-calender');
    }

	public function meeting(Request $request)
    {
    	if($request->ajax())
    	{
    		$data = Meeting::get(['id', 'title', 'start', 'end']);
            return response()->json($data);
    	}
    	return view('full-calender-meeting');
    }


    public function action(Request $request)
    {
    	if($request->ajax())
    	{
    		if($request->type == 'add')
    		{
    			$event = Event::create([
    				'title'		=>	$request->title,
    				'start'		=>	$request->start,
    				'end'		=>	$request->end
    			]);

    			return response()->json($event);
    		}

    		if($request->type == 'update')
    		{
    			$event = Event::find($request->id)->update([
    				'title'		=>	$request->title,
    				'start'		=>	$request->start,
    				'end'		=>	$request->end
    			]);

    			return response()->json($event);
    		}

    		if($request->type == 'delete')
    		{
    			$event = Event::find($request->id)->delete();

    			return response()->json($event);
    		}
    	}
	}

	public function actionmeet(Request $request)
	{
		if($request->ajax())
	
    	{
    		if($request->type == 'add')
    		{
    			$meeting = Meeting::create([
    				'title'		=>	$request->title,
    				'start'		=>	$request->start,
    				'end'		=>	$request->end
    			]);

    			return response()->json($meeting);
    		}

    		if($request->type == 'update')
    		{
    			$meeting = Meeting::find($request->id)->update([
    				'title'		=>	$request->title,
    				'start'		=>	$request->start,
    				'end'		=>	$request->end
    			]);

    			return response()->json($meeting);
    		}

    		if($request->type == 'delete')
    		{
    			$meeting = Meeting::find($request->id)->delete();

    			return response()->json($meeting);
    		}
    	}
    }
}
