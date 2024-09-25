<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\otpVerifcation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Config;
use App\Mail\OTPMail;

// models ...
use App\Models\User;
use App\Models\ClientQuery;
use App\Models\CompanyDetail;
use App\Models\Category;
use App\Models\Question;
use App\Models\AssignQuestion;
use App\Models\Product;
use App\Models\Order;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;


class DefualtController extends Controller
{
    protected $status;
    protected $user;
    private $menu_categories;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->status = config('constants.USER_STATUS');

        $this->menu_categories = Category::where('status', 'Active')
            ->with([
                'subcategory' => function ($query) {
                    $query->where('status', 'Active')
                        ->with([
                            'childCategories' => function ($query) {
                                $query->where('status', 'Active');
                            }
                        ]);
                }
            ])
            ->where('publish', 'Publish')
            ->latest('id')
            ->get()
            ->toArray();

        view()->share('menu_categories', $this->menu_categories);
    }

    public function profile_setting(Request $request)
    {
        $user = auth()->user();
        $page_name = 'setting';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }
        if ($request->all()) {
            $rules = [
                'name' => 'required',
                'phone' => 'required|digits:11',
                'address' => 'required',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($user->id),
                ],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['user'] = auth()->user();

            if ($request->file('user_pic')) {
                $image = $request->file('user_pic');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('user_images', $imageName, 'public');
                $ImagePath = 'user_images/' . $imageName;
            }
            $updateData = [
                'name' => ucwords($request->name),
                'email' => $request->email,
                'phone' => $request->phone,
                'user_pic' => $ImagePath ?? $user->user_pic,
                'address' => $request->address,
                'short_bio' => $request->short_bio,
                'status' => $this->status['Active'],
                'created_by' => $user->id,
            ];
            $saved = User::updateOrCreate(
                ['id' => $user->id ?? NULL],
                $updateData
            );
            $message = "profile" . ($user->id ? "Updated" : "Saved") . " Successfully";
            if ($saved) {
                return redirect()->route('admin.profileSetting')->with(['msg' => $message]);
            }
        }

        $data['user'] = $user;
        return view('admin.pages.profile_setting', $data);
    }

    public function password_change(Request $request)
    {
        $user = auth()->user();
        $page_name = 'setting';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }
        if ($request->all()) {
            $rules = [
                'current_password' => 'required',
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Check if the current password matches the one in the database
            if (Hash::check($request->current_password, $user->password)) {
                $hashedPassword = Hash::make($request->password);
                $updateData = [
                    'password' => $hashedPassword,
                    'created_by' => $user->id,
                ];
                $saved = User::updateOrCreate(
                    ['id' => $user->id ?? NULL],
                    $updateData
                );
                $message = "Password " . ($user->id ? "Updated" : "Saved") . " Successfully";
                if ($saved) {
                    return redirect()->route('admin.profileSetting')->with(['msg' => $message]);
                }
            } else {
                return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
            }
        }

        $data['user'] = $user;
        return view('admin.pages.profile_setting', $data);
    }

    public function faq()
    {
        return view('admin.pages.faq');
    }

    public function contact()
    {
        $user = auth()->user();
        $page_name = 'store_query';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }
        $data['user'] = auth()->user();
        if($user->role == user_roles(1)){
            $data['queries'] = ClientQuery::get()->toArray();
        }else{
            $data['queries'] = ClientQuery::where('user_id', $user->id)->get()->toArray();
        }
        $data['contact_details'] = CompanyDetail::get()->keyBy('content_type')->toArray();
        return view('admin.pages.contact', $data);
    }

    public function read_notifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function get_unread_notifications()
    {
        $unreadNotifications = Auth::user()->unreadNotifications;
        if ($unreadNotifications) {
            // notify()->success('New order received. ⚡️');
        }
        return response()->json($unreadNotifications);
    }

    public function store_query(Request $request)
    {
        $user = auth()->user();
        $page_name = 'store_query';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }
        if ($request->all()) {
            $rules = [
                'name'      => 'required',
                'subject'   => 'required',
                'message'   => 'required',
                'type'   => 'required',
                'email'     => [
                    'required',
                    'email',
                ],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                notify()->error("Fill the Form correctly. ⚡️");
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data['user'] = auth()->user();
            $query_data = [
                'user_id'    => $user->id,
                'name'       => ucwords($request->name),
                'email'      => $request->email,
                'subject'    => $request->subject,
                'message'    => $request->message,
                'type'       => $request->type,
                'created_by' => $user->id,
            ];
            $saved = ClientQuery::create(
                $query_data
            );
            $message = "Your Query " . ($request->id ? "Updated" : "Sent") . " Successfully. ⚡️";
            if ($saved) {
                notify()->success($message);
                return redirect()->back()->with(['msg' => $message]);
            }
        } else {
            notify()->error("Fill the Form correctly. ⚡️");
            return redirect()->back();
        }
    }

    public function store_company_details(Request $request)
    {
        $user = auth()->user();
        $page_name = 'company_details';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }
        if ($request->all()) {
            $data['user'] = auth()->user();
            $data = $request->all();
            foreach ($data as $key => $value) {
                if ($key !== '_token' && $key !== 'detail_type') {
                    $query_data = [
                        'detail_type'=> ucwords($request->detail_type),
                        'content_type' => $key,
                        'content'    => $value ?? null,
                        'created_by' => $user->id,
                        'updated_by' => $user->id,
                    ];
                    $saved = CompanyDetail::updateOrCreate(
                        ['content_type' => $key ?? NULL],
                        $query_data
                    );
                }
            }

            if ($saved) {
                $message = "Your Details are Updated Successfully. ⚡️";
                notify()->success($message);
                return redirect()->back()->with(['msg' => $message]);
            }
        } else {
            notify()->error("Fill the Form correctly. ⚡️");
            return redirect()->back();
        }
    }
}
