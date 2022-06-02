<?php

namespace App\Http\Controllers;

use App\Http\Requests\servicesRequest;
use App\Models\Project;
use App\Models\User;
use App\Notifications\Add_service_new;
use App\Notifications\AddServices;
use App\Traits\ImagesTrait;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notifiable;


class ServicesController extends Controller
{
    use ImagesTrait;


    public function myServices()
    {
        $my_id = auth()->user()->id;
        $my_Project = Project::where('user_id', $my_id)->get();
        if ($my_Project->count() == 0)
            return '<div style="margin-top: 300px;text-align: center;color:#721c24;background-color: #f8d7da;
                        border-color: #f5c6cb;padding: 0.75rem 1.25rem;
                        margin-bottom: 1rem;
                        border: 1px solid transparent;
                        border-radius: 0.25rem;">you don\'t have any service</div>';
        return view('user.myservice', compact('my_Project'));
    }





    public function getAll()
    {

        $services = Project::with('users', 'categories', 'subcategories')->where('approve_Id', 1)->where('user_id', '!=', Auth::id())->get();
        // return $services;
        return view('user.allservices', compact('services'));
    }






    /*
        public function getMoreProjects($id)
        {
            //$category = $request->category;

            //$projects = Project::getProjects($category);
            $data = Project::with('users', 'categories', 'subcategories')->where('project_category', $id)->get();
            \Log::info($data);
            return response()->json(['data' => $data]);
            //return view('user.allservices', compact('projects'))->render();
        }*/
    public function insert()
    {
        return view('user.insertServices');
    }

    public function store(servicesRequest $request)
    {
        $photo = $this->saveImage($request->service_photo, 'images/projects');
        $service = Project::create([
            'project_name' => $request->service_title,
            'project_photo' => $photo,
            'project_price' => $request->service_price,
            'project_category' => $request->service_cat,
            'project_subcategory' => $request->service_subcat,
            'user_id' => auth()->user()->id,
            'project_description' => $request->service_desc,
            'project_duration' => $request->service_duration,
            'approve_id' => 0,

        ]);
        /*for email notification*/
        $user = auth()->user();
        $service_id = Project::latest()->first()->id;
        Notification::send($user, new AddServices($service_id));


        /*for admin notification*/
        $USER = User::find(1);
        $SERVICE_ID = Project::latest()->first()->id;
        $USER->notify(new Add_service_new($SERVICE_ID));

        return redirect()->back()->with(['success' => 'Save Successfully']);


    }

    public function getservice($id)
    {
        $project = Project::with('users', 'categories', 'subcategories')->find($id);
        views($project)
            ->cooldown(10)
            ->record();
        $user_id = $project->user_id;
        $profile = User::with('profiles')->find($user_id);
        return view('user.showproject', compact('project', 'profile'));
    }
    public function delete($id)
    {
        $myService = Project::findOrFail($id);
        if ($myService) {
            $myService->delete();
            return redirect()->back()->with(['success' => 'deleted successfully']);

        }
    }

}
