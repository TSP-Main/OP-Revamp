<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\AdminDashboard\CreatePrescriptionMedQuestionRequest;
use App\Http\Requests\AdminDashboard\DeleteCategoryRequest;
use App\Http\Requests\AdminDashboard\DeletePMedQuestionRequest;
use App\Http\Requests\AdminDashboard\DeleteQuestionRequest;
use App\Http\Requests\AdminDashboard\QuestionMappingRequest;
use App\Http\Requests\AdminDashboard\StoreAdminRequest;
use App\Http\Requests\AdminDashboard\StoreAssignQuestRequest;
use App\Http\Requests\AdminDashboard\StoreFaqQuestionRequest;
use App\Http\Requests\AdminDashboard\StoreOrderRequest;
use App\Http\Requests\AdminDashboard\ChangeProductStatusRequest;
use App\Http\Requests\AdminDashboard\StorePmedQuestionRequest;
use App\Http\Requests\AdminDashboard\StoreQuestionCategoryRequest;
use App\Http\Requests\AdminDashboard\StoreQuestionRequest;
use App\Http\Requests\AdminDashboard\StoreSopRequest;
use App\Http\Requests\AdminDashboard\UpdateAdditionalNoteRequest;
use App\Models\ShippingDetail;
use App\Mail\RejectionEmail;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Mail\otpVerifcation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use League\Csv\Writer;
use SplTempFileObject;
use Response;


// models ...
use App\Models\Comment;
use App\Models\Pharmacy4uGpLocation;
use App\Models\shippedOrder;
use App\Models\QuestionCategory;
use App\Models\EmailLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\ShipingDetail;
use App\Models\Alert;
use App\Models\FaqProduct;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Question;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\AssignQuestion;
use App\Models\ProductVariant;
use App\Models\QuestionMapping;
use App\Models\PMedGeneralQuestion;
use App\Models\PrescriptionMedGeneralQuestion;
use App\Models\SOP;
use App\Models\HumanRequestForm;
use App\Traits\UserStatusTrait;

class AdminDashboardController extends Controller
{
    use UserStatusTrait;

    private $username = 'dkwrul3i0r4pwsgkko3nr8c4vs0h5yn5tunio398ik403.apps.vivapayments.com'; //client id
    private $password = 'BuLY8U1pEsXNPBgaqz98y54irE7OpL'; // secrit key

    private function getAccessToken()
    {
        try {
            $credentials = base64_encode($this->username . ':' . $this->password);

            // Make an HTTP request to obtain an access token
            $response = Http::asForm()->withHeaders([
                'Authorization' => 'Basic ' . $credentials,
            ])->post('https://accounts.vivapayments.com/connect/token', [
                'grant_type' => 'client_credentials',
            ]);

            // Check if the request was successful (status code 2xx)
            if ($response->successful()) {
                return $response->json('access_token');
            } else {
                // Log the error response for further investigation
                Log::error('Error response: ' . $response->body());
                return null;
            }
        } catch (\Exception $e) {
            // Log any exceptions that occurred during the request
            Log::error('Exception: ' . $e->getMessage());
            return null;
        }
    }

    public function index()
    {
        // return view('admin.pages.dashboard');
    }

    public function admins()
    {
        $user = $this->getAuthUser();
        $this->authorize('dispensaries');
        $data['user'] = $user;

        if ($user->hasRole('super_admin')) {
            $data['admins'] = User::with('profile', 'address')->role('dispensary')->latest('id')->get()->toArray();
        }

        return view('admin.pages.admins', $data);
    }

    public function add_admin(Request $request)
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('add_dispensary');

        $data['state_list'] = STATE_LIST();
        if ($request->has('id')) {
            $data['admin'] = User::with('profile', 'address')->findOrFail($request->id)->toArray();
        }

        return view('admin.pages.add_admin', $data);
    }

    public function store_admin(StoreAdminRequest $request)
    {
        $user = $this->getAuthUser();

        // Prepare data for creating or updating the admin
        $updateData = [
            'name' => ucwords($request->name),
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'zip_code' => $request->zip_code,
            'city' => $request->city,
            'state' => $request->state,
            'status' => $this->getUserStatus('Active'),
            'created_by' => $user->id,
        ];

        // Update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        // Create or update the user
        $saved = User::updateOrCreate(
            ['id' => $request->id ?? null],
            $updateData
        );

        // Assign the role using Spatie's Role system
        if ($saved) {
            $saved->syncRoles($request->role);
        }

        $message = "Admin " . ($request->id ? "Updated" : "Saved") . " Successfully";

        return redirect()->route('admin.admins')->with(['msg' => $message]);
    }

    // doctors managment ...
    public function doctors()
    {
        $user = $this->getAuthUser();
        $this->authorize('doctors');

        $data['user'] = $this->getAuthUser();

        if ($user->hasRole('super_admin')) {
            $data['doctors'] = User::with('address', 'profile')->role('doctor')->latest('id')->get()->toArray();
        }

        return view('admin.pages.doctors', $data);
    }

    public function add_doctor(Request $request)
    {
        $this->authorize('add_doctor');

        $data['user'] = $this->getAuthUser();
        if ($request->has('id')) {
            $data['doctor'] = User::with('address', 'profile')->findOrFail($request->id)->toArray();
        }

        return view('admin.pages.add_doctor', $data);
    }

    public function store_doctor(Request $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('add_doctor');

        // Start a DB transaction
        DB::beginTransaction();

        try {
            // User data to update
            $updateUserData = [
                'name' => ucwords($request->name),
                'email' => $request->email,
                'status' => $this->getUserStatus('Active'),
                'created_by' => $user->id,
            ];

            // If password is provided, hash and add it to the update data
            if ($request->password) {
                $updateUserData['password'] = Hash::make($request->password);
            }

            // Save or update user
            $savedUser = User::updateOrCreate(
                ['id' => $request->id ?? NULL],
                $updateUserData
            );

            $profileData = [
                'phone' => $request->phone,
                'gender' => $request->gender,
                'short_bio' => $request->short_bio,
            ];

            $savedUser->profile()->updateOrCreate(
                ['user_id' => $savedUser->id],
                $profileData
            );

            $addressData = [
                'address' => $request->address,
                'zip_code' => $request->zip_code,
                'city' => $request->city,
            ];

            $savedUser->address()->updateOrCreate(
                ['user_id' => $savedUser->id],
                $addressData
            );

            $savedUser->syncRoles($request->role);

            DB::commit();
            $message = "Doctor " . ($request->id ? "Updated" : "Saved") . " Successfully";
            return redirect()->route('admin.doctors')->with(['msg' => $message]);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with(['msg' => 'Operation failed. Please try again.']);
        }
    }

    //users management ...
    public function users()
    {
        $user = $this->getAuthUser();
        $this->authorize('users');
        $data['user'] = $user;
        if ($user->hasRole('super_admin')) {
            $data['users'] = User::with('profile', 'address')->role('user')->latest('id')->get()->toArray();
        }

        return view('admin.pages.users', $data);
    }

    // categories managment ...
    public function categories()
    {
        $user = $this->getAuthUser();
        $this->authorize('categories');
        $data['user'] = $user;

        if ($user->hasRole('super_admin')) {
            $data['categories'] = Category::where('status', 'Active')->latest('id')->get()->toArray();
        }

        return view('admin.pages.categories.categories', $data);
    }

    public function sub_categories()
    {
        $user = $this->getAuthUser();
        $this->authorize('sub_categories');
        $data['user'] = $user;

        if ($user->hasRole('super_admin')) {
            $data['categories'] = SubCategory::with('category')->where('status', 'Active')->latest('id')->get()->toArray();
        }

        return view('admin.pages.categories.sub_categories', $data);
    }

    public function child_categories()
    {
        $user = $this->getAuthUser();
        $this->authorize('child_categories');
        $data['user'] = $user;

        if ($user->hasRole('super_admin')) {
            $data['categories'] = ChildCategory::with('subcategory')->where('status', 'Active')->latest('id')->get()->toArray();
        }

        return view('admin.pages.categories.child_categories', $data);
    }

    public function add_category(Request $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('add_category');

        $data['user'] = $this->getAuthUser();
        $data['title'] = 'Add Category';
        if ($request->has('id')) {
            $data['title'] = 'Edit Category';
            if ($request->selection == 1) {
                $data['category'] = Category::findOrFail($request->id)->toArray();
                $data['selection'] = 1;
            } elseif ($request->selection == 2) {
                $data['category'] = SubCategory::findOrFail($request->id)->toArray();
                $data['selection'] = 2;
                $data['parents'] = Category::all()->toArray();
                $data['catName'] = 'category_id';
            } elseif ($request->selection == 3) {
                $data['category'] = ChildCategory::findOrFail($request->id)->toArray();
                $data['selection'] = 3;
                $data['parents'] = SubCategory::all()->toArray();
                $data['catName'] = 'sub_category_id';
            }
        }

        return view('admin.pages.categories.add_category', $data);
    }

    //sop management
    public function sops()
    {
        $user = $this->getAuthUser();
        $this->authorize('sops');

        $data['user'] = $this->getAuthUser();
        $data['title'] = "SOP's";
        if ($user->hasRole('super_admin')) {
            $data['sops'] = SOP::get()->toArray();
        } elseif ($user->hasRole('dispensary')) {
            $data['sops'] = SOP::whereIn('file_for', ['dispensary', 'both'])->get()->toArray();
        } elseif ($user->hasRole('doctor')) {
            $data['sops'] = SOP::whereIn('file_for', ['doctor', 'both'])->get()->toArray();
        }

        return view('admin.pages.sops.sops', $data);
    }

    public function add_sop($id = null)
    {
        $user = $this->getAuthUser();
        $this->authorize('add_sop');

        $data['user'] = $user;
        $data['title'] = 'Add SOP';;
        if ($id ?? null) {
            $data['title'] = 'Edit Category';
            $id = base64_decode($id);
            $data['sop'] = SOP::findOrFail($id)->toArray() ?? [];
        }

        return view('admin.pages.sops.add_sop', $data);
    }

    public function store_sop(StoreSopRequest $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('store_sop');

        // Handle file upload
        if ($request->hasFile('file')) {
            $sopFile = $request->file('file');
            $sopFileName = time() . '_' . uniqid('', true) . '.' . $sopFile->getClientOriginalExtension();
            $sopFile->storeAs('sop_file/', $sopFileName, 'public');
            $sopFilePath = 'sop_file/' . $sopFileName;
        }

        // Create or update the SOP entry
        $question = SOP::updateOrCreate(
            ['id' => $request->id ?? null],
            [
                'name' => ucwords($request->name),
                'file' => $sopFilePath ?? $request->sopFilePath_old,
                'file_for' => $request->file_for,
                'created_by' => $user->id,
            ]
        );

        if ($question->id) {
            $message = "SOP File " . ($request->id ? "Updated" : "Saved") . " Successfully";
            return redirect()->route('admin.sops')->with(['msg' => $message]);
        }
    }

    public function delete_sop($id)
    {
        $decodedId = base64_decode($id);
        $sop = SOP::findOrFail($decodedId);
        $sop->delete();

        return redirect()->back()->with('success', 'SOP deleted successfully.');
    }

    public function delete_old_category($old_id, $old_category_type)
    {
        // when type of category change than delete category from current type

        if ($old_category_type == 1) {
            $category = Category::findOrFail($old_id);
        } elseif ($old_category_type == 2) {
            $category = SubCategory::findOrFail($old_id);
        } elseif ($old_category_type == 3) {
            $category = ChildCategory::findOrFail($old_id);
        }
        $update = $category->update([
            'status' => 'Deleted',
        ]);

        return ['update' => $update, 'old_image_path' => $category->image];
    }

    public function update_product_categories($old_cat_id, $old_cat_type, $new_cat, $new_cat_type)
    {
        if ($old_cat_type == 1) {
            $products = Product::where('category_id', $old_cat_id)->get()->toArray();
        } elseif ($old_cat_type == 2) {
            $products = Product::where('sub_category', $old_cat_id)->get()->toArray();
        } elseif ($old_cat_type == 3) {
            $products = Product::where('child_category', $old_cat_id)->get()->toArray();
        }
        $response = true;
        if ($products) {
            $product_ids = array_column($products, 'id');
            if ($new_cat_type == 1) {
                $data = [
                    'category_id' => $new_cat->id,
                    'sub_category' => NULL,
                    'child_category' => NULL,
                    'updated_by' => auth()->user()->id,
                ];
                $response = Product::whereIn('id', $product_ids)->update($data);
            } elseif ($new_cat_type == 2) {
                $data = [
                    'category_id' => $new_cat->category_id,
                    'sub_category' => $new_cat->id,
                    'child_category' => NULL,
                    'updated_by' => auth()->user()->id,
                ];
                $response = Product::whereIn('id', $product_ids)->update($data);
            } elseif ($new_cat_type == 3) {
                $data = [
                    'category_id' => SubCategory::where(['id' => $new_cat->sub_category_id, 'status' => 'Active'])->value('category_id'),
                    'sub_category' => $new_cat->sub_category_id,
                    'child_category' => $new_cat->id,
                    'updated_by' => auth()->user()->id,
                ];
                $response = Product::whereIn('id', $product_ids)->update($data);
            }
        }
        return $response;
    }

    public function category_validation($request, $selection)
    {
        if ($selection == 1) {
            if ($request->change_type == 2) {
                $validator = Validator::make($request->all(), [
                    'publish' => 'required',
                    'name' => [
                        'required',
                        Rule::unique('categories')->where(function ($query) {
                            return $query->where('status', '!=', 'Deleted');
                        }),
                    ],
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'publish' => 'required',
                    'name' => [
                        'required',
                        Rule::unique('categories')->ignore($request->id),
                    ],
                ]);
            }
        } elseif ($selection == 2) {
            if ($request->change_type == 2) {
                $validator = Validator::make($request->all(), [
                    'publish' => 'required',
                    'parent_id' => 'required',
                    'name' => [
                        'required',
                        Rule::unique('sub_categories')->where(function ($query) use ($request) {
                            return $query->where('status', '!=', 'Deleted')
                                ->where('category_id', $request->parent_id);
                        }),
                    ],
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'publish' => 'required',
                    'parent_id' => 'required',
                    'name' => [
                        'required',
                        Rule::unique('sub_categories')->where(function ($query) use ($request) {
                            return $query->where('category_id', $request->parent_id);
                        })->ignore($request->id),
                    ],
                ]);
            }
        } elseif ($selection == 3) {
            if ($request->change_type == 2) {
                $validator = Validator::make($request->all(), [
                    'publish' => 'required',
                    'parent_id' => 'required',
                    'name' => [
                        'required',
                        Rule::unique('child_categories')->where(function ($query) use ($request) {
                            return $query->where('status', '!=', 'Deleted')
                                ->where('sub_category_id', $request->parent_id);;
                        }),
                    ],
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'publish' => 'required',
                    'parent_id' => 'required',
                    'name' => [
                        'required',
                        Rule::unique('child_categories')->where(function ($query) use ($request) {
                            return $query->where('sub_category_id', $request->parent_id);
                        })->ignore($request->id),
                    ],
                ]);
            }
        }

        return $validator;
    }

    public function store_category(Request $request)
    {
        // use for main,sub and child categories
        $user = $this->getAuthUser();
        $this->authorize('add_category');

        $selection = $request->selection;

        $validator = $this->category_validation($request, $selection);

        // return $validator;
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('image') || !$request->id) {
            $rules['image'] = [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,webm,svg,webp',
                'max:1024',
                // 'dimensions:max_width=1000,max_height=1000',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid('', true) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('category_images/', $imageName, 'public');
            $imagePath = 'category_images/' . $imageName;
        }


        if ($request->hasFile('icon') || !$request->id) {

            $rules['icon'] = [
                'image',
                'mimes:jpeg,png,jpg,gif,webm,svg,webp',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }


            $icon = $request->file('icon') ?? Null;
            if ($icon) {
                $iconName = time() . '_' . uniqid('', true) . '.' . $icon->getClientOriginalExtension();
                $icon->storeAs('category_icon/', $iconName, 'public');
                $iconPath = 'category_icon/' . $iconName;
            }
        }

        // if change type is 1 than updation will occur in same category
        // if change type is 2 than updation will occur in different category (convert child category into sub category)
        if ($selection == 1) {
            // Main Category
            if ($request->change_type == 2) {
                $response = $this->delete_old_category($request->old_id, $request->old_category_type);
                $saved = Category::create(
                    [
                        'name' => ucwords($request->name),
                        'slug' => Str::slug($request->name),
                        'desc' => $request->desc,
                        'publish' => $request->publish,
                        'image' => $imagePath ?? $response['old_image_path'],
                        'icon' => $iconPath ?? $response['icon'],
                        'created_by' => $user->id,
                    ]
                );
                $update_product = $this->update_product_categories($request->old_id, $request->old_category_type, $saved, 1);
            } else {
                $saved = Category::updateOrCreate(
                    ['id' => $request->id ?? NULL],
                    [
                        'name' => ucwords($request->name),
                        'slug' => Str::slug($request->name),
                        'desc' => $request->desc,
                        'publish' => $request->publish,
                        'image' => $imagePath ?? Category::findOrFail($request->id)->image,
                        'icon' => $iconPath ?? Category::findOrFail($request->id)->icon,
                        'created_by' => $user->id,
                    ]
                );
            }
            $message = "category " . ($request->id ? "Updated" : "Saved") . " Successfully";
            if ($saved) {
                return redirect()->route('admin.categories')->with(['msg' => $message]);
            }
        } elseif ($selection == 2) {
            // Sub Category
            if ($request->change_type == 2) {
                $response = $this->delete_old_category($request->old_id, $request->old_category_type);
                $saved = SubCategory::create(
                    [
                        'name' => ucwords($request->name),
                        'slug' => Str::slug($request->name),
                        'category_id' => $request->parent_id,
                        'desc' => $request->desc,
                        'publish' => $request->publish,
                        'image' => $imagePath ?? $response['old_image_path'],
                        'icon' => $iconPath ?? '',
                        'created_by' => $user->id,
                    ]
                );
                $update_product = $this->update_product_categories($request->old_id, $request->old_category_type, $saved, 2);
            } else {
                $saved = SubCategory::updateOrCreate(
                    ['id' => $request->id ?? NULL],
                    [
                        'name' => ucwords($request->name),
                        'slug' => Str::slug($request->name),
                        'category_id' => $request->parent_id,
                        'desc' => $request->desc,
                        'publish' => $request->publish,
                        'image' => $imagePath ?? SubCategory::findOrFail($request->id)->image,
                        'icon' => $iconPath ?? SubCategory::findOrFail($request->id)->icon,
                        'created_by' => $user->id,
                    ]
                );
            }
            $message = "sub category " . ($request->id ? "Updated" : "Saved") . " Successfully";
            if ($saved) {
                return redirect()->route('admin.subCategories')->with(['msg' => $message]);
            }
        } elseif ($selection == 3) {
            // Child Category
            if ($request->change_type == 2) {
                $response = $this->delete_old_category($request->old_id, $request->old_category_type);
                $saved = ChildCategory::create(
                    [
                        'name' => ucwords($request->name),
                        'slug' => Str::slug($request->name),
                        'sub_category_id' => $request->parent_id,
                        'desc' => $request->desc,
                        'publish' => $request->publish,
                        'image' => $imagePath ?? $response['old_image_path'],
                        'icon' => $imagePath ?? '',
                        'created_by' => $user->id,
                    ]
                );
                $update_product = $this->update_product_categories($request->old_id, $request->old_category_type, $saved, 3);
            } else {
                $saved = ChildCategory::updateOrCreate(
                    ['id' => $request->id ?? NULL],
                    [
                        'name' => ucwords($request->name),
                        'slug' => Str::slug($request->name),
                        'sub_category_id' => $request->parent_id,
                        'desc' => $request->desc,
                        'publish' => $request->publish,
                        'image' => $imagePath ?? ChildCategory::findOrFail($request->id)->image,
                        'icon' => $iconPath ?? ChildCategory::findOrFail($request->id)->icon,
                        'created_by' => $user->id,
                    ]
                );
            }
            $message = "child category " . ($request->id ? "Updated" : "Saved") . " Successfully";
            if ($saved) {
                return redirect()->route('admin.childCategories')->with(['msg' => $message]);
            }
        }
    }

    public function get_parent_category(Request $request)
    {
        $selection = $request->selection;
        if ($selection == 2) {
            $parents = Category::select('id', 'name')
                ->where('status', 'Active')
                ->pluck('name', 'id')
                ->toArray();
        } elseif ($selection == 3) {
            $parents = SubCategory::select('id', 'name')
                ->where('status', 'Active')
                ->pluck('name', 'id')
                ->toArray();
        }
        return response()->json(['status' => 'success', 'parents' => $parents]);
    }

    public function get_sub_category(Request $request)
    {
        $category_id = $request->category_id;
        $categories = SubCategory::select('id', 'name')
            ->where('status', 'Active')
            ->where('category_id', $category_id)
            ->pluck('name', 'id')
            ->toArray();

        return response()->json(['status' => 'success', 'sub_category' => $categories]);
    }

    public function get_child_category(Request $request)
    {
        $category_id = $request->category_id;
        $categories = ChildCategory::select('id', 'name')
            ->where('status', 'Active')
            ->where('sub_category_id', $category_id)
            ->pluck('name', 'id')
            ->toArray();

        return response()->json(['status' => 'success', 'child_category' => $categories]);
    }

    public function delete_category(DeleteCategoryRequest $request)
    {
        $this->authorize('dell_category');

        $status = 'Success';
        $message = "Category deleted Successfully";
        $class = 'bg-success';

        // Check if products are associated with the category
        $productExists = Product::where($request->cat_type, $request->id)
            ->where('status', 1)
            ->exists();

        if ($productExists) {
            $status = 'Failed';
            $message = "Category can't be deleted. Please delete associated products of that category first.";
            $class = 'bg-danger';
        } else {
            // Determine which category type to delete
            if ($request->cat_type === 'child_category') {
                $category = ChildCategory::findOrFail($request->id);
            } elseif ($request->cat_type === 'sub_category') {
                $category = SubCategory::findOrFail($request->id);
            } elseif ($request->cat_type === 'category_id') {
                $category = Category::findOrFail($request->id);
            }

            // Update the category status
            $category->update([
                'status' => $request->status,
            ]);
        }

        return response()->json(['status' => $status, 'message' => $message, 'data' => ['class' => $class]]);
    }

    public function trash_categories(Request $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('categories');
        $data['user'] = $user;
        $data['route'] = '';
        $data['cat_type'] = $request->cat_type;
        if ($request->cat_type === 'category_id') {
            $data['route'] = 'admin.categories';
            $data['categories'] = Category::where('status', 'Deactive')->latest('id')->get()->toArray();
        } elseif ($request->cat_type === 'sub_category') {
            $data['route'] = 'admin.subCategories';
            $data['categories'] = SubCategory::with('category')->where('status', 'Deactive')->latest('id')->get()->toArray();
        } elseif ($request->cat_type === 'child_category') {
            $data['route'] = 'admin.childCategories';
            $data['categories'] = ChildCategory::with('subcategory')->where('status', 'Deactive')->latest('id')->get()->toArray();
        } else {
            return redirect()->back();
        }

        return view('admin.pages.categories.trash_categories', $data);
    }

    // question management ...
    public function question_categories()
    {
        $user = $this->getAuthUser();
        $this->authorize('question_categories');

        $data['user'] = $user;

        if ($user->hasRole('super_admin')) {
            $data['categories'] = QuestionCategory::latest('id')->get()->toArray();
        }

        return view('admin.pages.questions.question_categories', $data);
    }

    public function add_question_category(Request $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('add_question_category');

        $data['user'] = $user;
        if ($request->has('id')) {
            $data['category'] = QuestionCategory::findOrFail($request->id)->toArray();
        }

        return view('admin.pages.questions.add_question_category', $data);
    }

    public function store_question_category(StoreQuestionCategoryRequest $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('add_question_category'); // Authorization

        // Save or update the question category
        $saved = QuestionCategory::updateOrCreate(
            ['id' => $request->id ?? NULL],
            [
                'name' => ucwords($request->name),
                'desc' => $request->desc,
                'publish' => $request->publish,
                'created_by' => $user->id,
            ]
        );

        $message = "category " . ($request->id ? "Updated" : "Saved") . " Successfully";

        if ($saved) {
            return redirect()->route('admin.questionCategories')->with(['msg' => $message]);
        }
    }

    public function questions()
    {
        $user = $this->getAuthUser();
        $this->authorize('questions');

        $data['user'] = $user;
        $data['categories'] = [];
        if ($user->hasRole('super_admin')) {
            $data['questions'] = Question::where(['status' => 'Active'])
                ->orderBy('category_title')
                ->orderByRaw('IF(`order` IS NULL, 1, 0), CAST(`order` AS UNSIGNED), `order`')
                ->orderBy('id')
                ->get()
                ->toArray();
            if ($data['questions']) {
                $data['categories'] = array_unique(array_column($data['questions'], 'category_title'));
            }
        }

        return view('admin.pages.questions.questions', $data);
    }

    public function trash_questions(Request $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('questions');
        $data['user'] = $user;
        $data['route'] = '';
        $data['q_type'] = $request->q_type;
        if ($request->q_type === 'pro_question') {
            $data['route'] = 'admin.questions';
            $data['categories'] = [];
            if (isset($user->role) && $user->role == user_roles('1')) {
                $data['questions'] = Question::where(['status' => 'Deactive'])
                    ->orderBy('category_title')
                    ->orderByRaw('IF(`order` IS NULL, 1, 0), CAST(`order` AS UNSIGNED), `order`')
                    ->orderBy('id')
                    ->get()
                    ->toArray();
                if ($data['questions']) {
                    $data['categories'] = array_unique(array_column($data['questions'], 'category_title'));
                }
            }
        } elseif ($request->q_type === 'pmd_question') {
            $data['questions'] = PMedGeneralQuestion::where(['status' => 'Deactive'])->get()->toArray();
        } elseif ($request->q_type === 'pre_question') {
            $data['questions'] = PrescriptionMedGeneralQuestion::where(['status' => 'Active'])->get()->toArray();
        } else {
            return redirect()->back();
        }

        return view('admin.pages.questions.trash_questions', $data);
    }

    public function faq_questions()
    {
        $user = $this->getAuthUser();
        $this->authorize('faq_questions');

        $data['user'] = $user;
        $data['categories'] = [];
        if ($user->hasRole('super_admin')) {
            $data['questions'] = FaqProduct::where(['status' => 'Active'])
                ->orderBy('product_id')
                ->orderByRaw('IF(`order` IS NULL, 1, 0), CAST(`order` AS UNSIGNED), `order`')
                ->orderBy('id')
                ->get()
                ->toArray();
            if ($data['questions']) {
                $data['products'] = array_unique(array_column($data['questions'], 'product_title'));
            }
        }

        return view('admin.pages.questions.faq_questions', $data);
    }

    public function p_med_general_questions()
    {
        $this->authorize('p_med_gq');

        $data['user'] = $this->getAuthUser();
        $data['questions'] = PMedGeneralQuestion::where(['status' => 'Active'])->get()->toArray();

        return view('admin.pages.questions.p_med_gq', $data);
    }

    public function prescription_med_general_questions()
    {
        $this->authorize('prescription_med_gq');

        $data['user'] = $this->getAuthUser();
        $data['questions'] = PrescriptionMedGeneralQuestion::where(['status' => 'Active'])->get()->toArray();

        return view('admin.pages.questions.prescription_med_gq', $data);
    }

    public function add_question(Request $request)
    {
        $this->authorize('add_question');
        $data['user'] = $this->getAuthUser();
        $data['categories'] = QuestionCategory::latest('id')->get()->toArray();
        if ($request->has('id')) {
            $data['question'] = Question::findOrFail($request->id)->toArray();
        }
        return view('admin.pages.questions.add_question', $data);
    }

    public function add_faq_question(Request $request)
    {
        $this->authorize('faq_questions');
        $data['user'] = $this->getAuthUser();
        $data['products'] = Product::where(['status' => '1'])->latest('id')->get()->toArray();
        if ($request->has('id')) {
            $data['question'] = FaqProduct::findOrFail($request->id)->toArray();
        }
        return view('admin.pages.questions.add_faq_question', $data);
    }

    public function store_question(StoreQuestionRequest $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('add_question');
        $data['user'] = $user;

        $question = Question::updateOrCreate(
            ['id' => $request->id ?? NULL],
            [
                'category_id' => $request->category_id,
                'category_title' => QuestionCategory::findOrFail($request->category_id)->name,
                'title' => ucwords($request->title),
                'desc' => $request->desc ?? NULL,
                'is_assigned' => $request->is_assigned,
                'anwser_set' => $request->anwser_set,
                'type' => $request->type,
                'yes_lable' => ucwords($request->yes_lable) ?? NULL,
                'no_lable' => ucwords($request->no_lable) ?? NULL,
                'optA' => ucwords($request->optA) ?? NULL,
                'optB' => ucwords($request->optB) ?? NULL,
                'optC' => ucwords($request->optC) ?? NULL,
                'optD' => ucwords($request->optD) ?? NULL,
                'order' => $request->order ?? null,
                'is_dependent' => ($request->type == 'non_dependent') ? 'no' : 'yes',
                'created_by' => $user->id,
            ]
        );

        if ($question->id) {
            if ($question->is_assigned == 'yes') {
                $options = ['optA', 'optB', 'optC', 'optD', 'optY', 'optN', 'openBox', 'file'];

                foreach ($options as $option) {
                    $value = $request->next_quest[$option];
                    $selector = 'nothing';

                    if ($value['next_type'] == 'alert') {
                        $alert = Alert::updateOrCreate(
                            [
                                'question_id' => $question->id,
                                'q_category_id' => $question->category_id,
                                'option' => $option,
                            ],
                            [
                                'type' => $value['alert_type'],
                                'body' => $value['alert_msg'],
                                'route' => 'web.productQuestion',
                                'option' => $option,
                                'question_id' => $question->id,
                                'q_category_id' => $question->category_id,
                                'created_by' => $user->id
                            ]
                        );

                        if ($alert->id) {
                            $selector = $alert->id;
                            $mapped = QuestionMapping::updateOrCreate(
                                [
                                    'question_id' => $question->id,
                                    'category_id' => $question->category_id,
                                    'answer' => $option,
                                ],
                                [
                                    'next_type' => 'alert',
                                    'selector' => $alert->id,
                                    'status' => 1,
                                    'created_by' => $user->id
                                ]
                            );
                        } else {
                            return response()->json('alert is not saved');
                        }
                    } elseif ($value['next_type'] == 'question') {
                        $selector = $value['question'];
                        $mapped = QuestionMapping::updateOrCreate(
                            [
                                'question_id' => $question->id,
                                'category_id' => $question->category_id,
                                'answer' => $option,
                            ],
                            [
                                'next_type' => 'question',
                                'selector' => $selector,
                                'status' => 1,
                                'created_by' => $user->id
                            ]
                        );
                    } else {
                        $mapped = QuestionMapping::updateOrCreate(
                            [
                                'question_id' => $question->id,
                                'category_id' => $question->category_id,
                                'answer' => $option,
                            ],
                            [
                                'next_type' => 'nothing',
                                'selector' => $selector,
                                'status' => 1,
                                'created_by' => $user->id
                            ]
                        );
                    }
                }
            }

            $message = "Question " . ($request->id ? "Updated" : "Saved") . " Successfully";
            return redirect()->route('admin.questions')->with(['msg' => $message]);
        }
    }

    public function store_faq_question(StoreFaqQuestionRequest $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('faq_questions');

        $question = FaqProduct::updateOrCreate(
            ['id' => $request->id ?? NULL],
            [
                'product_id' => $request->product_id,
                'product_title' => Product::findOrFail($request->product_id)->title,
                'order' => $request->order,
                'title' => ucwords($request->title),
                'desc' => $request->desc ?? NULL,
                'created_by' => $user->id,
            ]
        );

        if ($question->id) {
            $message = "FAQ question " . ($request->id ? "Updated" : "Saved") . " Successfully";
            return redirect()->route('admin.faqQuestions')->with(['msg' => $message]);
        }
    }

    public function delete_question(DeleteQuestionRequest $request)
    {
        $this->authorize('dell_question');

        $status = 'Success';
        $action = ($request->status == 'Active') ? ' Reverted ' : (($request->status == 'Deactive') ? ' Sent to Trash ' : ' Deleted ');
        $message = "Question " . $action . " Successfully";
        $class = ($request->status == 'Deleted') ? 'bg-danger' : 'bg-success';

        // Fetch the question based on the type
        if ($request->q_type === 'pro_question') {
            $question = Question::findOrFail($request->id);
        } elseif ($request->q_type === 'pmd_question') {
            $question = PMedGeneralQuestion::findOrFail($request->id);
        } elseif ($request->q_type === 'pre_question') {
            $question = PrescriptionMedGeneralQuestion::findOrFail($request->id);
        }

        // Update the status
        $question->update([
            'status' => $request->status,
        ]);

        return response()->json(['status' => $status, 'message' => $message, 'data' => ['class' => $class]]);
    }


    // question assignment management...
    public function assign_question()
    {
        // question mapping screen
        $user = $this->getAuthUser();
        $this->authorize('assign_question');
        $data['user'] = $user;
        if ($user->hasRole('super_admin')) {
            $data['categories'] = QuestionCategory::where(['status' => 'Active'])->latest('id')->get()->toArray();
        }
        return view('admin.pages.questions.assign_question', $data);
    }

    public function get_assign_quest(Request $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('assign_question');

        $questions = [];

        if ($user->hasRole('super_admin') && $request->has('id')) {
            $questions = Question::select('id', 'title', 'order')
                ->where(['category_id' => $request->id, 'status' => 'Active'])
                ->orderByRaw('IF(`order` IS NULL, 1, 0), CAST(`order` AS UNSIGNED), `order`')
                ->orderBy('id')
                ->get()
                ->toArray();
        }

        return response()->json(['status' => 'success', 'questions' => $questions]);
    }

    public function store_assign_quest(StoreAssignQuestRequest $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('assign_question');

        // Delete previous records for the given category_id
        AssignQuestion::where('category_id', $request->category_id)->delete();

        // Loop through each question_id and insert new records
        foreach ($request->question_id ?? [] as $questionId) {
            AssignQuestion::create([
                'category_id' => $request->category_id,
                'category_title' => Category::findOrFail($request->category_id)->name,
                'question_id' => $questionId,
                'question_title' => Question::findOrFail($questionId)->title,
                'status' => $this->getUserStatus('Active'),
                'created_by' => $user->id,
            ]);
        }

        $message = "Data Updated Successfully";
        return redirect()->back()->with(['msg' => $message, 'category_id' => $request->category_id]);
    }


    // Question Mapping ...
    public function question_mapping(QuestionMappingRequest $request)
    {
        $user = $this->getAuthUser();
        // Remove in-method validation since it's handled in the request class
        $options = ['optA', 'optB', 'optC', 'optD', 'optY', 'optN', 'openBox', 'file'];

        foreach ($options as $option) {
            $value = $request->$option;

            if ($value !== null && $value !== '') {
                QuestionMapping::updateOrCreate(
                    [
                        'category_id' => $request->category_id,
                        'question_id' => $request->question_id,
                        'answer' => $option,
                    ],
                    [
                        'category_id' => $request->category_id,
                        'question_id' => $request->question_id,
                        'answer' => $option,
                        'next_question' => $value,
                        'status' => 1,
                        'created_by' => $user->id
                    ]
                );
            }
        }

        $message = "Data Saved Successfully";
        return redirect()->back()->with(['msg' => $message]);
    }

    public function question_detail(Request $request)
    {
        $question_id = $request->id;
        $category_id = $request->categoryId;
        $result['detail'] = Question::findOrFail($question_id)->toArray();
        $result['other_qstn'] = Question::select('id', 'title')
            ->where(['category_id' => $category_id, 'is_dependent' => 'yes', 'status' => 'Active'])
            ->orderBy('id')
            ->pluck('title', 'id')
            ->toArray();

        $result['dependant_question'] = QuestionMapping::where('category_id', $category_id)
            ->where('question_id', $question_id)
            ->get();
        return response()->json(['status' => 'success', 'result' => $result]);
    }

    public function get_next_question(Request $request)
    {
        $question_id = $request->id;
        $category_id = $request->categoryId;
        $answer = $request->answer;
        $result['detail'] = Question::findOrFail($question_id)->toArray();

        $result['other_qstn'] = AssignQuestion::join('assign_questions as tbl2', function ($join) use ($question_id) {
            $join->on('assign_questions.category_id', '=', 'tbl2.category_id')
                ->where('tbl2.question_id', '!=', $question_id);
        })
            ->select('tbl2.question_id', 'tbl2.question_title')
            ->where('assign_questions.question_id', $question_id)
            ->where('assign_questions.category_id', $category_id)
            ->pluck('tbl2.question_title', 'tbl2.question_id')
            ->toArray();

        return response()->json(['status' => 'success', 'result' => $result]);
    }

    public function get_dp_questions(Request $request)
    {
        $category_id = $request->cat_id;
        $result['dp_qstn'] = Question::select('id', 'title')
            ->where(['category_id' => $category_id, 'is_dependent' => 'yes', 'status' => 'Active'])
            ->orderBy('id')
            ->pluck('title', 'id')
            ->toArray();
        if ($result['dp_qstn']) {
            return response()->json(['status' => 'success', 'result' => $result]);
        } else {
            return response()->json(['status' => 'empty', 'result' => []]);
        }
    }

    // orders managment ...
    public function order_detail(Request $request)
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('orders');
    
        if (!$request->id) {
            return redirect()->back()->with('error', 'Order not found.');
        }
    
        $id = base64_decode($request->id);
        $order = Order::with(['user', 'shippingDetail', 'orderdetails.product', 'orderdetails.variant'])
            ->where(['id' => $id, 'payment_status' => 'Paid'])
            ->first();
    
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }
    
        // Fetch user orders
        $data['userOrders'] = Order::whereHas('shippingDetail', function ($query) use ($order) {
                $query->where('email', $order->shippingDetail->email);
            })
            ->where('payment_status', 'Paid')
            ->where('id', '!=', $order->id)
            ->pluck('id')
            ->toArray();
    
        // Prepare order data
        $data['order'] = $order->toArray();
        $data['order']['shipping_cost'] = $order->shippingDetail->cost ?? 0;
    
        // Shipping details
        $data['order']['shipping_details'] = $order->shippingDetail->only(['firstName', 'lastName', 'phone', 'email', 'city','product_status', 'zip_code', 'address','tracking_no']);
    
      // Calculate subtotal for approved products based on product table prices
        $data['order']['total_amount'] = $order->orderdetails->sum(function ($detail) {
            return in_array($detail->product_status, ['1', '3']) ? 
                ($detail->product->price * $detail->product_qty) : 0;
        });
            
         // Add product images and variant details to order details
         $data['order']['orderdetails'] = $order->orderdetails->map(function ($detail) {
        $detail->product_image = $detail->product->main_image ?? null;
          // Process variant information if variant_id exists
    if ($detail->variant_id) {
        $variant = ProductVariant::find($detail->variant_id);
        if ($variant) {
            $vart_type = explode(';', $variant->title);
            $vart_value = explode(';', $variant->value);
            $var_info = '';

            foreach ($vart_type as $key => $type) {
                $var_info .= "<b>$type:</b> {$vart_value[$key]}";
                if ($key < count($vart_type) - 1) {
                    $var_info .= ', ';
                }
            }
            $detail->variant_details = $var_info; // Store formatted variant info
        } else {
            $detail->variant_details = 'N/A'; 
        }
    } else {
        $detail->variant_details = 'N/A';
    }

    return $detail;
});
    
        // Marked by user
        if ($order->approved_by) {
            $data['marked_by'] = User::find($order->approved_by);
        }
    
        return view('admin.pages.order_detail', $data);
    }
    
    

    // public function consultation_view(Request $request)
    // {
    //     $data['user'] = $this->getAuthUser();
    //     $this->authorize('consultation_view');
    //     if ($request->odd_id) {
    //         $odd_id = base64_decode($request->odd_id);
    //         $user_result = [];
    //         $prod_result = [];
    //         $consultaion = OrderDetail::where(['id' => $odd_id])->latest('created_at')->latest('id')->first();
    //         if ($consultaion) {
    //             $consutl_quest_ans = json_decode($consultaion->generic_consultation, true);
    //             $consult_quest_keys = array_keys(array_filter($consutl_quest_ans, function ($value) {
    //                 return $value !== null;
    //             }));
    //             if ($consultaion->consultation_type == 'pmd') {
    //                 $consult_questions = PMedGeneralQuestion::whereIn('id', $consult_quest_keys)->select('id', 'title', 'desc')->get()->toArray();
    //             } elseif ($consultaion->consultation_type == 'premd') {
    //                 $consult_questions = PrescriptionMedGeneralQuestion::whereIn('id', $consult_quest_keys)->select('id', 'title', 'desc')->get()->toArray();
    //                 $pro_quest_ans = json_decode($consultaion->product_consultation, true);
    //                 $pro_quest_ids = array_keys(array_filter($pro_quest_ans, function ($value) {
    //                     return $value !== null;
    //                 }));
    //                 $product_consultation = Question::whereIn('id', $pro_quest_ids)->orderBy('id')->get()->toArray();
    //                 $product_consultation = collect($product_consultation)->mapWithKeys(function ($item) {
    //                     return [$item['id'] => $item];
    //                 });

    //                 foreach ($pro_quest_ans as $q_id => $answer) {
    //                     if (isset($product_consultation[$q_id])) {
    //                         $prod_result[] = [
    //                             'id' => $q_id,
    //                             'title' => $product_consultation[$q_id]['title'],
    //                             'desc' => $product_consultation[$q_id]['desc'],
    //                             'answer' => $answer,
    //                         ];
    //                     }
    //                 }
    //             }
    //             $consult_questions = collect($consult_questions)->mapWithKeys(function ($item) {
    //                 return [$item['id'] => $item];
    //             });

    //             foreach ($consutl_quest_ans as $quest_id => $ans) {
    //                 if (isset($consult_questions[$quest_id])) {
    //                     $user_result[] = [
    //                         'id' => $quest_id,
    //                         'title' => $consult_questions[$quest_id]['title'],
    //                         'desc' => $consult_questions[$quest_id]['desc'],
    //                         'answer' => $ans,
    //                     ];
    //                 }
    //             }

    //             $data['order'] = Order::where(['id' => $consultaion->order_id])->first();
    //             $data['order_user_detail'] = ShippingDetail::where(['order_id' => $consultaion->order_id, 'status' => 'Active'])->latest('created_at')->latest('id')->first();
    //             $data['user_profile_details'] = (isset($data['order_user_detail']['user_id']) && $consultaion->consultation_type != 'pmd') ? User::findOrFail($data['order_user_detail']['user_id']) : [];
    //             $data['generic_consultation'] = $user_result;
    //             $data['product_consultation'] = $prod_result ?? [];
    //             return view('admin.pages.consultation_view', $data);
    //         } else {
    //             notify()->error('Consultaions Id Did not found. ⚡️');
    //             return redirect()->back()->with('error', 'Transaction not found.');
    //         }
    //     } else {
    //         notify()->error('Consultaions Id Did not found. ⚡️');
    //         return redirect()->back();
    //     }
    // }

    public function consultation_view(Request $request)
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('consultation_view');
    
        if ($request->odd_id) {
            $odd_id = base64_decode($request->odd_id);
            $user_result = [];
            $prod_result = [];
            $consultaion = OrderDetail::where(['id' => $odd_id])
                ->latest('created_at')
                ->latest('id')
                ->first();
    
            if ($consultaion) {
                $consutl_quest_ans = json_decode($consultaion->generic_consultation, true);
                $consult_quest_keys = array_keys(array_filter($consutl_quest_ans, function ($value) {
                    return $value !== null;
                }));
    
                if ($consultaion->consultation_type == 'pmd') {
                    $consult_questions = PMedGeneralQuestion::whereIn('id', $consult_quest_keys)
                        ->select('id', 'title', 'desc')
                        ->get()
                        ->toArray();
                } elseif ($consultaion->consultation_type == 'premd' || $consultaion->consultation_type == 'premd/Reorder') {
                    $consult_questions = PrescriptionMedGeneralQuestion::whereIn('id', $consult_quest_keys)
                        ->select('id', 'title', 'desc')
                        ->get()
                        ->toArray();
    
                    $pro_quest_ans = json_decode($consultaion->product_consultation, true);
                    $pro_quest_ids = array_keys(array_filter($pro_quest_ans, function ($value) {
                        return $value !== null;
                    }));
    
                    $product_consultation = Question::whereIn('id', $pro_quest_ids)
                        ->orderBy('id')
                        ->get(['id', 'title', 'desc'])
                        ->toArray();
    
                    $product_consultation = collect($product_consultation)->mapWithKeys(function ($item) {
                        return [$item['id'] => $item];
                    });
    
                    foreach ($pro_quest_ans as $q_id => $answer) {
                        if (isset($product_consultation[$q_id])) {
                            $prod_result[] = [
                                'id' => $q_id,
                                'title' => $product_consultation[$q_id]['title'],
                                'desc' => $product_consultation[$q_id]['desc'],
                                'answer' => $answer,
                                'product_id' => $consultaion->product_id ?? null, // Include product_id from OrderDetail
                            ];
                        }
                    }
                }
    
                $consult_questions = collect($consult_questions)->mapWithKeys(function ($item) {
                    return [$item['id'] => $item];
                });
    
                foreach ($consutl_quest_ans as $quest_id => $ans) {
                    if (isset($consult_questions[$quest_id])) {
                        $user_result[] = [
                            'id' => $quest_id,
                            'title' => $consult_questions[$quest_id]['title'],
                            'desc' => $consult_questions[$quest_id]['desc'],
                            'answer' => $ans,
                            'product_id' => $consultaion->product_id ?? null,
                        ];
                    }
                }
    
                $data['order'] = Order::where(['id' => $consultaion->order_id])->first();
                $data['order_user_detail'] = ShippingDetail::where(['order_id' => $consultaion->order_id, 'status' => 'Active'])
                    ->latest('created_at')
                    ->latest('id')
                    ->first();
                $data['user_profile_details'] = (isset($data['order_user_detail']['user_id']) && $consultaion->consultation_type != 'pmd') ?
                    User::findOrFail($data['order_user_detail']['user_id']) : [];
                $data['generic_consultation'] = $user_result;
                $data['product_consultation'] = $prod_result ?? [];
    
                return view('admin.pages.consultation_view', $data);
            } else {
                notify()->error('Consultations Id Did not found. ⚡️');
                return redirect()->back()->with('error', 'Transaction not found.');
            }
        } else {
            notify()->error('Consultations Id Did not found. ⚡️');
            return redirect()->back();
        }
    } 


    public function consultation_form_edit(Request $request)
    {  
        $data['user'] = $this->getAuthUser();
        $this->authorize('consultation_view');
    
        if ($request->odd_id) {
            $odd_id = base64_decode($request->odd_id);
            $consultaion = OrderDetail::where(['id' => $odd_id])->latest()->first();
    
            if ($consultaion) {
                // Fetching consultation questions and answers
                $consutl_quest_ans = json_decode($consultaion->generic_consultation, true);
                $consult_quest_keys = array_keys(array_filter($consutl_quest_ans, fn($value) => $value !== null));
    
                if ($consultaion->consultation_type == 'pmd') {
                    $consult_questions = PMedGeneralQuestion::whereIn('id', $consult_quest_keys)->get(['id', 'title', 'desc'])->toArray();
                } else {
                    $consult_questions = PrescriptionMedGeneralQuestion::whereIn('id', $consult_quest_keys)->get(['id', 'title', 'desc'])->toArray();
    
                    // Fetch the product consultation answers
                    $pro_quest_ans = json_decode($consultaion->product_consultation, true);
                    $pro_quest_ids = array_keys(array_filter($pro_quest_ans, fn($value) => $value !== null));
                    $product_consultation = Question::whereIn('id', $pro_quest_ids)
                        ->orderBy('id')
                        ->get(['id', 'title', 'desc'])
                        ->toArray();
    
                    // Map the product questions with keys
                    $product_consultation = collect($product_consultation)->mapWithKeys(function ($item) {
                        return [$item['id'] => $item];
                    });
    
                    // Prepare the product consultation answers
                    foreach ($pro_quest_ans as $q_id => $answer) {
                        if (isset($product_consultation[$q_id])) {
                            $prod_result[] = [
                                'id' => $q_id,
                                'title' => $product_consultation[$q_id]['title'],
                                'desc' => $product_consultation[$q_id]['desc'],
                                'answer' => $answer,
                                'product_id' => $consultaion->product_id ?? null,
                            ];
                        }
                    }
                }
    
                // Prepare user results for generic consultation
                $user_result = [];
                foreach ($consutl_quest_ans as $quest_id => $ans) {
                    if (isset($consult_questions[$quest_id])) {
                        $user_result[] = [
                            'id' => $quest_id,
                            'title' => $consult_questions[$quest_id]['title'],
                            'desc' => $consult_questions[$quest_id]['desc'],
                            'answer' => $ans,
                        ];
                    }
                }
    
                $data['generic_consultation'] = $user_result;
                $data['product_consultation'] = $prod_result ?? [];
                $data['order'] = Order::find($consultaion->order_id);
                $data['order_user_detail'] = ShippingDetail::where(['order_id' => $consultaion->order_id, 'status' => 'Active'])->latest()->first();
                $data['user_profile_details'] = $data['order_user_detail'] ? User::find($data['order_user_detail']->user_id) : [];
    
                $data['order_detail_id'] = $consultaion->id;
    
                // Check if either 607 or 800 is in the product consultation
                $requires_image_upload_607 = collect($prod_result)->contains(function ($value) {
                    return $value['id'] == 607;
                });
    
                $requires_image_upload_800 = collect($prod_result)->contains(function ($value) {
                    return $value['id'] == 800;
                });
    
                // Store flags for image upload requirements
                $data['requires_image_upload_607'] = $requires_image_upload_607;
                $data['requires_image_upload_800'] = $requires_image_upload_800;
    
                // Step 1: Fetch new questions for the product category
                $category_id = $consultaion->product->question_category; // Assuming this is where category_id is stored
                $new_product_questions = Question::where('category_id', $category_id)
                    ->where('type', 'non_dependent') // Only non-dependent questions
                    ->whereNotIn('id', array_keys($pro_quest_ans)) // Exclude already answered questions
                    ->where('status', 'Active') // Only active questions
                    ->get();
    
                // Pass new product questions to the view
                $data['new_product_questions'] = $new_product_questions;
    
                // Handle form submission
                if ($request->isMethod('post')) {
                    $request->validate([
                        'answers.generic' => 'required|array',
                        'answers.product' => 'array',
                        'image_607' => 'nullable|image|max:2048', // Validate image for 607 if provided
                        'image_800' => 'nullable|image|max:2048', // Validate image for 800 if provided
                    ]);
    
                    \Log::info('Request Method: ' . $request->method());
                    \Log::info($request->all());
    
                    // Extract answers from request
                    $answers = $request->input('answers');
    
                    // Handle image upload for 607 if provided
                    if ($request->hasFile('image_607')) {
                        $image_607 = $request->file('image_607');
                        $imagePath_607 = $image_607->store('consultation/product', 'public'); // Store in the 'public' disk
    
                        // Replace the answer for question #607 with the image path
                        $answers['product'][607] = $imagePath_607;
                    }
    
                    // Handle image upload for 800 if provided
                    if ($request->hasFile('image_800')) {
                        $image_800 = $request->file('image_800');
                        $imagePath_800 = $image_800->store('consultation/product', 'public'); // Store in the 'public' disk
    
                        // Replace the answer for question #800 with the image path
                        $answers['product'][800] = $imagePath_800;
                    }
    
                    // Save updated answers back to the consultation
                    $consultaion->generic_consultation = json_encode($answers['generic']);
                    $consultaion->product_consultation = json_encode($answers['product'] ?? []);
                    $consultaion->save();
    
                    notify()->success('Consultation updated successfully.');
                    return redirect()->route('admin.consultationFormEdit', ['odd_id' => base64_encode($odd_id)]);
                }
    
                return view('admin.pages.consultation_formedit', $data);
            } else {
                notify()->error('Consultation Id not found. ⚡️');
                return redirect()->back()->with('error', 'Transaction not found.');
            }
        } else {
            notify()->error('Consultation Id not found. ⚡️');
            return redirect()->back();
        }
    }

    public function ordersReceived()
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('orders_received');
        $orders = Order::with(['user', 'shippingDetails:id,order_id,firstName,lastName,email', 'orderdetails:id,order_id,consultation_type'])->where(['payment_status' => 'Paid', 'status' => 'Received'])->latest('created_at')->get()->toArray();

        if ($orders) {
            $data['order_history'] = $this->get_prev_orders($orders);
            $data['orders'] = $this->assign_order_types($orders);
        }
        

        return view('admin.pages.orders_recieved', $data);
    }

    public function all_orders(Request $request)
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('orders_received');
        $orders = Order::with(['user', 'shippingDetails:id,order_id,firstName,lastName,email', 'orderdetails:id,order_id,consultation_type'])->where(['payment_status' => 'Paid'])->latest('created_at')->get()->toArray();

        if ($orders) {
            $data['order_history'] = $this->get_prev_orders($orders);
            $data['orders'] = $this->assign_order_types($orders);
        }
    
        return view('admin.pages.order_all', $data);
    }
    
    
    public function otc_orders()
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('dispensary_approval');
        $orders = Order::with(['user', 'shippingDetails:id,order_id,firstName,lastName,email', 'orderdetails:id,order_id,consultation_type'])
        ->where('payment_status', 'Paid')  // Filter for orders with 'Paid' status
        ->get()  
        ->filter(function ($order) {
            // Check if all order details have consultation type 'one_over'
            return $order->orderdetails->every(function ($orderDetail) {
                return $orderDetail->consultation_type === 'one_over';
            });
        })
        ->toArray();

        if ($orders) {
            $data['order_history'] = $this->get_prev_orders($orders);
            $data['orders'] = $this->assign_order_types($orders);
        }

        return view('admin.pages.order_otc', $data);
    }

    public function unpaid_orders()
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('orders_received');
        $orders = Order::with(['user', 'shippingDetails:id,order_id,firstName,lastName', 'orderdetails:id,order_id,consultation_type'])->where(['payment_status' => 'Unpaid'])->latest('created_at')->get()->toArray();

        if ($orders) {
            $data['order_history'] = $this->get_prev_orders($orders);
            $data['orders'] = $this->assign_order_types($orders);
        }

        return view('admin.pages.order_unpaid', $data);
    }

    public function orders_created()
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('orders_created');
        $orders = Order::with(['user', 'shippingDetails:id,order_id,firstName,lastName,email', 'orderdetails:id,order_id,consultation_type'])->where(['payment_status' => 'Unpaid', 'status' => 'Created'])
            ->orWhere('status', 'Duplicate')
            ->latest('created_at')->get()->toArray();
        if ($orders) {
            $data['order_history'] = $this->get_prev_orders($orders);
            $data['orders'] = $this->assign_order_types($orders);
        }
        return view('admin.pages.orders_created', $data);
    }

    public function duplicate_Order(Request $request)
    {
        $orderId = $request->input('order_id');
        $existingOrder = Order::with(['shippingDetails', 'orderdetails'])->find($orderId);

        if (!$existingOrder) {
            return redirect()->back()->with(['error' => 'Order not found.']);
        }

        try {
            // Create a new order record
            $newOrder = Order::create([
                'user_id' => $existingOrder->user_id,
                // 'email' => $existingOrder->shippingDetails->email,
                'note'           => $existingOrder->note,
                'payment_status' => 'Unpaid',
                'shiping_cost'   => $existingOrder->shiping_cost,
                'coupon_code'    => $existingOrder->coupon_code,
                'coupon_value'   => $existingOrder->coupon_value,
                'total_ammount'  => $existingOrder->total_ammount,
                'status' => 'Duplicate', // Update status as needed
            ]);

            if (!$newOrder) {
                throw new \Exception('Failed to duplicate order.');
            }

            // Create new shipping details for the duplicated order
            $newShippingDetail = ShippingDetail::create([
                'order_id'    =>  $newOrder->id,
                'user_id'     => $existingOrder->user_id,
                'firstName'   => $existingOrder->shippingDetails->firstName,
                'lastName'    => $existingOrder->shippingDetails->lastName,
                'email'       => $existingOrder->shippingDetails->email,
                'phone'       => $existingOrder->shippingDetails->phone,
                'address'     => $existingOrder->shippingDetails->address,
                'address2'    => $existingOrder->shippingDetails->address2,
                'city'        => $existingOrder->shippingDetails->city,
                'zip_code'    => $existingOrder->shippingDetails->zip_code,
                'method'      => $existingOrder->shippingDetails->method,
                'cost'        => $existingOrder->shippingDetails->cost,
                'state'       => $existingOrder->shippingDetails->state,
                'status'      => 'Created', // Assuming status should be reset to Created
                'created_by'  => auth()->id(),
                'updated_by'  => auth()->id(),
            ]);

            if (!$newShippingDetail) {
                throw new \Exception('Failed to duplicate shipping details.');
            }

            // dd($existingOrder->orderdetails );

            foreach ($existingOrder->orderdetails as $orderDetail) {
                $newOrderDetail = OrderDetail::create([
                    'order_id'     => $newOrder->id,
                    'product_id'   => $orderDetail->product_id,
                    'variant_id'   => $orderDetail->variant_id,
                    'product_qty'  => $orderDetail->product_qty,
                    'generic_consultation' => $orderDetail->generic_consultation,
                    'product_consultation' => $orderDetail->product_consultation,
                    'consultation_type'    => $orderDetail->consultation_type,
                    'status'               => 'Duplicate', // Update status as needed/
                    'created_by'           => auth()->id(),
//                    'weight' => $orderDetail->weight,
//                    'product_name' => $orderDetail->product_name,
//                    'variant_details' => $orderDetail->variant_details,
//                    'product_price' => $orderDetail->product_price,
                ]);


                if (!$newOrderDetail) {
                    throw new \Exception('Failed to duplicate order detail.');
                }
            }

            // Redirect back with success message
            $message = "Order and Shipping Details Duplicated Successfully";
            return redirect()->route('admin.ordersReceived')->with(['msg' => $message]);
        } catch (\Exception $e) {
            // Handle exceptions and errors
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function orders_refunded()
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('orders_refunded');
        $orders = Order::with(['user', 'shippingDetails:id,order_id,firstName,lastName,email', 'orderdetails:id,order_id,consultation_type'])->where(['payment_status' => 'Paid', 'status' => 'Refund'])->latest('created_at')->get()->toArray();
        if ($orders) {
            $data['order_history'] = $this->get_prev_orders($orders);
            $data['orders'] = $this->assign_order_types($orders);
        }

        return view('admin.pages.orders_refunded', $data);
    }

    public function doctors_approval()
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('doctors_approval');
        if (isset($data['user']->role) && $data['user']->role == user_roles('2')) {
            $orders = Order::with(['user', 'approved_by:id,name,email', 'shippingDetails:id,order_id,firstName,lastName,email', 'orderdetails:id,order_id,consultation_type'])->where(['payment_status' => 'Paid', 'status' => 'Approved', 'order_for' => 'doctor'])->whereIn('status', ['Received', 'Approved', 'Not_Approved', 'Partially_Approved'])->latest('created_at')->get()->toArray();
        } else {
            $orders = Order::with(['user', 'approved_by:id,name,email', 'shippingDetails:id,order_id,firstName,lastName,email', 'orderdetails:id,order_id,consultation_type'])->where(['payment_status' => 'Paid', 'order_for' => 'doctor'])
                ->whereIn('status', ['Received', 'Approved', 'Not_Approved', 'Partially_Approved'])
                ->latest('created_at')->get()->toArray();
        }
        if ($orders) {
            $data['order_history'] = $this->get_prev_orders($orders);
            $data['orders'] = $this->assign_order_types($orders);
            //dd( $data['orders']);
        }
        return view('admin.pages.doctors_approval', $data);
    }

    public function dispensary_approval()
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('dispensary_approval');
        $orders = Order::with(['user', 'shippingDetails:id,order_id,firstName,lastName,email', 'orderdetails:id,order_id,consultation_type'])
            ->where(['payment_status' => 'Paid', 'order_for' => 'despensory'])
            ->whereIn('status', ['Received', 'Approved', 'Not_Approved'])
            ->latest('created_at')
            ->get()
            ->toArray();

        if ($orders) {
            $data['order_history'] = $this->get_prev_orders($orders);
            $data['orders'] = $this->assign_order_types($orders);
        }
        return view('admin.pages.dispensary_approval', $data);
    }

    public function orders_shipped()
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('orders_shipped');
        $orders = Order::with(['user', 'shippingDetails:id,order_id,firstName,lastName,email', 'orderdetails:id,order_id,consultation_type'])->where(['payment_status' => 'Paid', 'status' => 'Shipped'])->latest('created_at')->get()->toArray();
        if ($orders) {
            $data['order_history'] = $this->get_prev_orders($orders);
            $data['orders'] = $this->assign_order_types($orders);
        }

        return view('admin.pages.orders_shipped', $data);
    }

    public function orders_unshipped()
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('orders_unshipped');
        $orders = Order::with(['user', 'shippingDetails:id,order_id,firstName,lastName,email', 'orderdetails:id,order_id,consultation_type'])->where(['payment_status' => 'Paid', 'status' => 'ShippingFail'])->latest('created_at')->get()->toArray();
        if ($orders) {
            $data['order_history'] = $this->get_prev_orders($orders);
            $data['orders'] = $this->assign_order_types($orders);
        }

        return view('admin.pages.orders_unshipped', $data);
    }

    public function gpa_letters()
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('gpa_letters');
        $orders = Order::with(['user.profile', 'shippingDetails:id,order_id,firstName,lastName,address,email', 'orderdetails'])->where(['payment_status' => 'Paid', 'order_for' => 'doctor'])->whereIn('status', ['Approved', 'Shipped'])->orderBy('id', 'DESC')->get()->toArray();
        if ($orders) {
            $data['order_history'] = $this->get_prev_orders($orders);
            $data['orders'] = $this->assign_order_types($orders);
        }
        return view('admin.pages.gpa_letters', $data);
    }

    public function vet_prescriptions()
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('vet_prescription');
        $data['queries'] = HumanRequestForm::latest('created_at')->get()->toArray();

        return view('admin.pages.orders.vet_prescriptions', $data);
    }

    public function delete_human_form($id)
    {
        $decodedId = base64_decode($id);
        $sop = SOP::findOrFail($decodedId);
        $sop->delete();

        return redirect()->back()->with('success', 'SOP deleted successfully.');
    }

    public function orders_audit()
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('orders_shipped');

        $orders = Order::with([
            'user',
            'shippingDetails',
            'orderdetails' => function ($query) {
                $query->with('product:id,title');
            }
        ])
            ->where(['payment_status' => 'Paid', 'status' => 'Shipped'])
            ->latest('created_at')
            ->get()
            ->toArray();


        $data['filters'] = [];
        $postalCodeProductCount = [];

        if ($orders) {
            $combined = array_map(function ($order) {
                return $order['shipping_details']['address'] . '_chapi_' . $order['shipping_details']['zip_code'];
            }, $orders);

            $uniqueCombined = array_unique($combined);

            $filters = array_map(function ($item) {
                $parts = explode('_chapi_', $item, 2);
                return [
                    'address' => $parts[0],
                    'postal_code' => $parts[1]
                ];
            }, $uniqueCombined);

            $data['filters'] = $filters;

            // Aggregate product counts by postal code
            foreach ($orders as $order) {
                $postalCode = $order['shipping_details']['zip_code'];
                foreach ($order['orderdetails'] as $detail) {
                    if (!isset($postalCodeProductCount[$postalCode])) {
                        $postalCodeProductCount[$postalCode] = [];
                    }
                    $productId = $detail['product']['title'];
                    if (!isset($postalCodeProductCount[$postalCode][$productId])) {
                        $postalCodeProductCount[$postalCode][$productId] = 0;
                    }
                    $postalCodeProductCount[$postalCode][$productId]++;
                }
            }

            $data['postalCodeProductCount'] = $postalCodeProductCount;
            $data['orders'] = $this->assign_order_types($orders);
        }

        return view('admin.pages.orders_audit', $data);
    }


    public function add_order()
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('orders_created');
        $data['products'] = Product::with('variants')->where('status', $this->getUserStatus('Active'))->latest('id')->get()->sortBy('title')->values()->keyBy('id')->toArray();

        foreach ($data['products'] as $key => $product) {
            if ($product['variants']) {
                $data['variants'][$product['id']] = $product['variants'];
            }
        }
        // Fetch active users who have the 'user' role
        // Fetch active users with their addresses and profiles (including phone)
        $data['users'] = User::where('status', $this->getUserStatus('Active'))
            ->whereHas('roles', function ($query) {
                $query->where('name', 'user'); // Ensure the user has the 'user' role
            })
            ->with(['address', 'profile']) // Eager load both 'address' and 'user_profile' relations
            ->orderBy('name')
            ->get()
            ->keyBy('id') // Key by user ID
            ->toArray();
    
        // If you want to add the phone number to the user profile data in the view
        foreach ($data['users'] as &$user) {
            $user['phone'] = $user['profile']['phone'] ?? null; // Fetch phone from the user profile, if available
        }
    
        return view('admin.pages.add_order', $data);
    }
    

    public function store_order(StoreOrderRequest $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('orders_created');

        $shippingCost = $request->shiping_cost;

        // Determine the shipping method based on the shipping cost
        if ($shippingCost == 3.95) {
            $shippingMethod = 'fast';
        } elseif ($shippingCost == 4.95) {
            $shippingMethod = 'express';
        } elseif ($shippingCost == 0.00) {
            $shippingMethod = 'free';
        } elseif ($shippingCost == 15.00) {
            $shippingMethod = ' International';
        } else {
            $shippingMethod = 'Default Method'; // Example fallback
        }

        $order = Order::create([
            'user_id' => $request->user_id ?? 'guest',
            'email' => $request->email,
            'note' => $request->note,
            'shiping_cost' => $shippingMethod,
            'coupon_code' => $request->coupon_code ?? null,
            'coupon_value' => $request->coupon_value ?? null,
            'total_ammount' => $request->total_amount ?? null,
            'status' => 'Created',
        ]);

        if ($order) {
            $shippingDetail = ShippingDetail::create([
                'order_id' => $order->id,
                'user_id' => $request->user_id ?? 'guest',
                'firstName' => $request->firstName,
                'lastName' => $request->lastName ?? null,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'address2' => $request->address2 ?? null,
                'city' => $request->city,
                'zip_code' => $request->zip_code,
                'method' => $shippingMethod,
                'cost' => $request->shiping_cost,
                'state' => $request->state ?? null,
                'status' => 'Created',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            $consultaiontype = 'one_over';
            $productTemplate = 'null';
            $hasTemplate1 = false;
            $hasTemplate3 = false;

            // Determine the consultation type and product template
            foreach ($request->all() as $key => $value) {
                if (preg_match('/^pro_(\d+)_qty$/', $key, $matches)) {
                    $productId = $matches[1];
                    $product = Product::find($productId);

                    if ($product) {
                        if ($product->product_template == 2) {
                            $productTemplate = $product->product_template;
                            $consultaiontype = 'premd';
                            break;
                        }

                        if ($product->product_template == 1) {
                            $hasTemplate1 = true;
                        }

                        if ($product->product_template == 3) {
                            $hasTemplate3 = true;
                        }
                    }
                }
            }

            if (!isset($consultaiontype)) {
                if ($hasTemplate1 && $hasTemplate3) {
                    $consultaiontype = 'pmd';
                }
            }

            // Save order details
            foreach ($request->all() as $key => $value) {
                if (preg_match('/^pro_(\d+)_qty$/', $key, $matches)) {
                    $productId = $matches[1];
                    $quantity = $value;
                    $variantKey = "pro_{$productId}_vari";
                    $variantId = $request->input($variantKey, null);

                    $product = Product::find($productId);
                    $variant = ProductVariant::find($variantId);

                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $productId,
                        'variant_id' => $variantId,
//                        'product_name' => $product ? $product->title : 'Unknown Product',
//                        'variant_details' => $variant ? $variant->slug : 'No Variant',
//                        'weight' => $product ? $product->weight : 0,
                        'product_qty' => $quantity,
//                        'product_price' => $product ? $product->price : 0,
//                        'status' => 'Created',
                        'consultation_type' => $consultaiontype,
                        'created_by' => $user->id,
                        'updated_by' => $user->id,
                    ]);
                }
            }
            // dd($shippingDetail);

            if ($shippingDetail) {
                $message = "Order and Shipping Details Saved Successfully";
                return redirect()->route('admin.ordersCreated')->with(['msg' => $message]);
            }
        }

        return redirect()->back()->with(['error' => 'Failed to save order and shipping details']);
    }

    public function changeProductStatus(ChangeProductStatusRequest $request)
    {
        // The request is validated at this point
    
        $orderId = $request->order_id;
        $approvals = $request->approvals;
    
        // Map status to numerical values
        $statusMap = [
            'Not Approved' => '2',
            'Approved' => '3',
        ];
    
        // Process each approval
        foreach ($approvals as $approval) {
            // Log each approval before updating
            \Log::info('Updating product status:', [
                'order_id' => $orderId,
                'product_id' => $approval['product_id'],
                'status' => $approval['status'],
            ]);
    
            // Update the product status in the order_details table
            DB::table('order_details')
                ->where('order_id', $orderId)
                ->where('product_id', $approval['product_id'])
                ->update(['product_status' => $statusMap[$approval['status']]]);
        }
    
        // Redirect with success message
        return redirect()->back()->with('success', 'Product status updated successfully.');
    }
    

    public function change_status(Request $request)
    {
        // Authorize the action
        $this->authorize('orders');
    
        // Validate incoming request data
        $validatedData = $request->validate([
            'id' => 'required|exists:orders,id',
            'status' => 'required',
        ]);
    
        // Find and update the order
        $order = Order::findOrFail($validatedData['id']);
        $order->status = $validatedData['status'];
        $order->hcp_remarks = $request->hcp_remarks ?? null;
    
        if ($request->approved_by) {
            $order->approved_by = $request->approved_by;
            $order->approved_at = now();
        }
    
        // Save the updated order
        $update = $order->save();
    
        if ($update) {
            // Prepare success message
            $msg = 'Order is ' . $validatedData['status'];
            $status = 'success';
    
            // Send email if the order is rejected
            if ($validatedData['status'] === 'Not_Approved') {
                // Retrieve the email from the shippingDetail table
                $shippingDetail = $order->shippingDetail; // Adjust based on your relationship
                $recipientEmail = $shippingDetail ? $shippingDetail->email : null;
    
                // Check if the email is valid
                if (!empty($recipientEmail) && filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
                    $email = new RejectionEmail($order, $order->hcp_remarks);
                    \Mail::to($recipientEmail)->send($email);
    
                    // Log the email
                    EmailLog::create([
                        'order_id' => $order->id,
                        'email_to' => $recipientEmail,
                        'subject' => 'Order Rejection Notification',
                        'body' => 'Your order has been rejected. Remarks: ' . $order->hcp_remarks,
                    ]);
                } else {
                    \Log::error('Invalid email address for order ID ' . $order->id);
                    // Optionally, set a session message for the admin about the invalid email
                }
            }
    
            // Redirect to the order details page with success status
            return redirect()->route('admin.orderDetail', ['id' => base64_encode($validatedData['id'])])
                             ->with('status', $status)
                             ->with('msg', $msg);
        }
    
        // Redirect back if the update was not successful
        return redirect()->back();
    }
    
    
    public function EmailLog()
    {
        // Fetch all email logs from the database
        $emailLogs = EmailLog::orderBy('created_at', 'desc')->paginate(10); // Paginate results

        // Return the view with the email logs
        return view('admin.pages.order_reject_log', compact('emailLogs'));
    }


    public function get_shipping_order(Request $request)
    {
        // Get order ID from the request
        $order_id = $request->id;
    
        // Fetch the ShippingDetail record for the given order ID
        $shippingDetail = ShippingDetail::where('order_id', $order_id)->first();
    
        // If the ShippingDetail record doesn't exist, return early with a message
        if (!$shippingDetail) {
            return redirect()->route('admin.orderDetail', ['id' => base64_encode($order_id)])
                ->with('status', 'fail')
                ->with('msg', 'Shipping detail not found');
        }
    
        // Set up the API request
        $apiKey = '74b1b61e-efd0-4932-be7d-7a27276f26e3';
        $client = new Client();
        $response = $client->get('https://api.parcel.royalmail.com/api/v1/orders/' . $shippingDetail->order_identifier, [
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
            ]
        ]);
    
        // Decode the API response
        $body = json_decode($response->getBody()->getContents(), true);
    
        // Check if the response status is successful and contains tracking numbers
        $tracking_nos = $response->getStatusCode() === 200 && isset($body[0]['trackingNumber']) ? [$body[0]['trackingNumber']] : null;
    
        // If tracking number is found, update the shipping detail
        if ($tracking_nos) {
            $shippingDetail->tracking_no = $tracking_nos[0];
            $shippingDetail->save();
    
            return redirect()->route('admin.orderDetail', ['id' => base64_encode($order_id)])
                ->with('status', 'success')
                ->with('msg', 'Order is Tracked');
        }
    
        // If no tracking number is found, set the status as failed
        return redirect()->route('admin.orderDetail', ['id' => base64_encode($order_id)])
            ->with('status', 'fail')
            ->with('msg', 'Order tracking failed');
    }
    public function create_shipping_order(Request $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('orders');
        
        $validatedData = $request->validate([
            'id' => 'required|exists:orders,id'
        ]);
        
        // Fetch the order with the related models
        $order = Order::with(['user', 'shippingDetails', 'orderdetails.product', 'orderdetails.product.variants'])
                      ->where([
                          'id' => $request->id,
                          'payment_status' => 'Paid'
                      ])
                      ->first();
        
        if ($order) {
            try {
                $order = $order->toArray();
                $weightSum = 0;
        
                // Calculate total weight using the product weight from the product table
                foreach ($order['orderdetails'] as $orderDetail) {
                    $product = $orderDetail['product']; // Accessing the 'product' relation
                    $weightSum += ($product['weight'] ?? 0) * $orderDetail['product_qty']; // Multiply by quantity
                }
        
                // Update weight and quantity for the order
                $order['weight'] = $weightSum !== 0 ? floatval($weightSum) : 1;
                $order['quantity'] = array_sum(array_column($order['orderdetails'], 'product_qty'));
        
                // Create the shipping payload for the API
                $payload = $this->make_shiping_payload($order);
                $apiKey = env('ROYAL_MAIL_API_KEY');
                $client = new Client();
                $response = $client->post('https://api.parcel.royalmail.com/api/v1/orders', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $apiKey,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => $payload,
                ]);
        
                $statusCode = $response->getStatusCode();
                $body = $response->getBody()->getContents();
        
                if ($statusCode == 200) {
                    $response = json_decode($body, true);
                    $shipped = [];
                    
                    if ($response['createdOrders']) {
                        foreach ($response['createdOrders'] as $val) {
                            // Create or update ShippingDetail
                            $shipped[] = ShippingDetail::updateOrCreate(
                                ['order_id' => $order['id']],
                                [
                                    'order_identifier' => $val['orderIdentifier'],
                                    'tracking_no' => $this->get_tracking_number($val['orderIdentifier']) ?? null,
                                    'shipping_status' => 'Shipped',
                                    'created_by' => $user->id,
                                ]
                            );
        
                            // Deduct stock for each product in the order
                            foreach ($order['orderdetails'] as $orderDetail) {
                                $product = $orderDetail['product'];
                                $product_qty = $orderDetail['product_qty'];
                                
                                // If the order has a variant_id (which means a variant was selected), deduct from the variant
                                if ($orderDetail['variant_id']) {
                                    $variant = ProductVariant::find($orderDetail['variant_id']);
                                    
                                    if ($variant) {
                                        // Deduct stock from the variant
                                        $variant->inventory -= $product_qty;
                                        
                                        // Check if the variant stock is 0, and update stock status to "OUT"
                                        if ($variant->inventory <= 0) {
                                            $variant->stock_status = 'OUT';
                                            $variant->save();
                                        } else {
                                            $variant->save();
                                        }
                                    } else {
                                        Log::error("Variant not found for order detail ID: {$orderDetail['id']}");
                                    }
                                } else {
                                    // If no variant, deduct from the main product stock
                                    $productModel = Product::find($product['id']);
                                    
                                    if ($productModel) {
                                        // Deduct stock from the main product
                                        $productModel->stock -= $product_qty;
                                        
                                        // Check if the product stock is 0, and update stock status to "OUT"
                                        if ($productModel->stock <= 0) {
                                            $productModel->stock_status = 'OUT';
                                            $productModel->save();
                                        } else {
                                            $productModel->save();
                                        }
                                    } else {
                                        Log::error("Product not found for order detail ID: {$orderDetail['id']}");
                                    }
                                }
                            }
                        }
                    }
        
                    // Update the order status to "Shipped"
                    $orderModel = Order::findOrFail($order['id']);
                    $orderModel->status = $shipped[0]->shipping_status;
                    $orderModel->save();
                    
                    // Return success message
                    $msg = ($shipped[0]->shipping_status == 'Shipped') ? 'Order is shipped' : 'Order shipping failed';
                    $status = ($shipped[0]->shipping_status == 'Shipped') ? 'success' : 'fail';
                    return redirect()->route('admin.orderDetail', ['id' => base64_encode($validatedData['id'])])
                                     ->with('status', $status)
                                     ->with('msg', $msg);
                } else {
                    Log::error("Royal Mail API failed with status code: {$statusCode}");
                    return redirect()->route('admin.orderDetail', ['id' => base64_encode($validatedData['id'])])
                                     ->with('status', 'fail')
                                     ->with('msg', 'Error with shipping API.');
                }
            } catch (\Exception $e) {
                Log::error("Error during shipping order creation: " . $e->getMessage());
                return redirect()->back()->with('status', 'fail')
                                        ->with('msg', 'An error occurred while processing the shipping order.');
            }
        }
        
        return redirect()->back()->with('status', 'fail')->with('msg', 'Order not found or payment not confirmed.');
    }
    
    
    public function batchShipping(Request $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('orders');
        
        $validatedData = $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id'
        ]);
        
        $shippedOrders = [];
        $failedOrders = [];
        
        foreach ($validatedData['order_ids'] as $orderId) {
            $order = Order::with('user', 'shippingDetails', 'orderdetails.product', 'orderdetails.product.variants')
                          ->where(['id' => $orderId, 'payment_status' => 'Paid'])
                          ->first();
        
            if ($order) {
                try {
                    $order = $order->toArray();
                    
                    // Calculate weight and quantity
                    $weightSum = array_sum(array_column($order['orderdetails'], 'weight'));
                    $order['weight'] = $weightSum !== 0 ? floatval($weightSum) : 1;
                    $order['quantity'] = array_sum(array_column($order['orderdetails'], 'product_qty'));
        
                    // Prepare the payload for shipping
                    $payload = $this->make_shiping_payload($order);
                    $apiKey = env('ROYAL_MAIL_API_KEY');
                    $client = new Client();
                    
                    $response = $client->post('https://api.parcel.royalmail.com/api/v1/orders', [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $apiKey,
                            'Content-Type' => 'application/json',
                        ],
                        'json' => $payload,
                    ]);
        
                    $statusCode = $response->getStatusCode();
                    $body = $response->getBody()->getContents();
        
                    if ($statusCode == 200) {
                        $response = json_decode($body, true);
                        
                        if (!empty($response['createdOrders'])) {
                            foreach ($response['createdOrders'] as $val) {
                                $shippedOrders[] = ShippingDetail::updateOrCreate(
                                    ['order_id' => $order['id']],
                                    [
                                        'order_identifier' => $val['orderIdentifier'],
                                        'tracking_no' => $this->get_tracking_number($val['orderIdentifier']) ?? null,
                                        'shipping_status' => 'Shipped',
                                        'created_by' => $user->id,
                                    ]
                                );
        
                                // Deduct stock and update stock status
                                foreach ($order['orderdetails'] as $orderDetail) {
                                    $product = $orderDetail['product'];
                                    $product_qty = $orderDetail['product_qty'];
                                    
                                    // If the order has a variant_id (which means a variant was selected), deduct from the variant
                                    if ($orderDetail['variant_id']) {
                                        $variant = ProductVariant::find($orderDetail['variant_id']);
                                        
                                        if ($variant) {
                                            // Deduct stock from the variant
                                            $variant->inventory -= $product_qty;
                                            
                                            // Check if the variant stock is 0, and update stock status to "OUT"
                                            if ($variant->inventory <= 0) {
                                                $variant->stock_status = 'OUT';
                                                $variant->save();
                                            } else {
                                                $variant->save();
                                            }
                                        } else {
                                            Log::error("Variant not found for order detail ID: {$orderDetail['id']}");
                                        }
                                    } else {
                                        // If no variant, deduct from the main product stock
                                        $productModel = Product::find($product['id']);
                                        
                                        if ($productModel) {
                                            // Deduct stock from the main product
                                            $productModel->stock -= $product_qty;
                                            
                                            // Check if the product stock is 0, and update stock status to "OUT"
                                            if ($productModel->stock <= 0) {
                                                $productModel->stock_status = 'OUT';
                                                $productModel->save();
                                            } else {
                                                $productModel->save();
                                            }
                                        } else {
                                            Log::error("Product not found for order detail ID: {$orderDetail['id']}");
                                        }
                                    }
                                }
                            }
        
                            // Update the order status to "Shipped"
                            $orderToUpdate = Order::findOrFail($order['id']);
                            $orderToUpdate->status = 'Shipped';
                            $orderToUpdate->save();
                        }
        
                        if (!empty($response['failedOrders'])) {
                            foreach ($response['failedOrders'] as $val) {
                                $failedOrders[] = [
                                    'order_id' => $order['id'],
                                    'order_identifier' => $val['orderIdentifier'],
                                    'errors' => json_encode($val['errors'] ?? []),
                                    'status' => 'ShippingFail',
                                ];
                            }
                        }
                    } else {
                        // Log and handle errors if the API response is not 200
                        Log::error('Batch Shipping Error: ' . $body);
                        $failedOrders[] = [
                            'order_id' => $order['id'],
                            'errors' => 'API response was not 200.',
                        ];
                    }
                } catch (\Exception $e) {
                    Log::error('Batch Shipping Exception: ' . $e->getMessage());
                    $failedOrders[] = [
                        'order_id' => $orderId,
                        'errors' => $e->getMessage(),
                    ];
                }
            } else {
                Log::warning("Order ID {$orderId} not found or not paid.");
                $failedOrders[] = [
                    'order_id' => $orderId,
                    'errors' => 'Order not found or not paid.',
                ];
            }
        }
        
        // Return response with summary of shipped and failed orders
        return response()->json([
            'shippedOrders' => $shippedOrders,
            'failedOrders' => $failedOrders,
        ]);
    }
    
    
    
    

    private function get_tracking_number($orderId)
    {
        $order_id = $orderId;
        $tracking_nos = Null;
        $apiKey = env('ROYAL_MAIL_API_KEY');

        $client = new Client();
        $response = $client->get('https://api.parcel.royalmail.com/api/v1/orders/' . $order_id, [
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
            ]
        ]);
        $statusCode = $response->getStatusCode();
        $body = json_decode($response->getBody()->getContents(), true);
        if ($statusCode == '200') {
            $tracking_nos = array_column($body, 'trackingNumber');
            //dd($response, $statusCode,$body, $tracking_nos);
        }
        return $tracking_nos[0] ?? Null;
    }

    private function make_shiping_payload($order)
    {
        $content = [];
        foreach ($order['orderdetails'] as $val) {
            $content[] = [
                "name" => $val['product']['title'],
                "SKU" => null,
                "quantity" => $val['product_qty'],
                "unitValue" => $val['product']['price'],
                "unitWeightInGrams" => floatval($val['product']['weight']),
                "customsDescription" => 'it is a medical product.',
                "extendedCustomsDescription" => "",
                "customsCode" => null,
                "originCountryCode" => "GB",
                "customsDeclarationCategory" => null,
                "requiresExportLicence" => null,
                "stockLocation" => null
            ];
        }

        $order_ref = $order['id'];
        $payload = [
            "items" => [
                [
                    "orderReference" => $order_ref,
                    "recipient" => [
                        "address" => [
                            "fullName" => ($order['shipping_details']['firstName']) ? $order['shipping_details']['firstName'] . ' ' . $order['shipping_details']['lastName'] : $order['user']['name'],
                            "companyName" => null,
                            "addressLine1" => $order['shipping_details']['address'] ?? $order['user']['address'],
                            "addressLine2" => $order['shipping_details']['address2'] ?? '',
                            "addressLine3" => null,
                            "city" => $order['shipping_details']['city'] ?? $order['user']['city'],
                            "county" => "United Kingdom",
                            "postcode" => $order['shipping_details']['zip_code'] ?? $order['user']['zip_code'],
                            "countryCode" => "GB"
                        ],
                        "phoneNumber" => $order['shipping_details']['phone'] ?? $order['user']['phone'],
                        "emailAddress" => $order['shipping_details']['email'] ?? $order['user']['email'],
                        "addressBookReference" => null
                    ],
                    "sender" => [
                        "tradingName" => 'onlinepharmacy-4u',
                        "phoneNumber" => '01623572757',
                        "emailAddress" => 'info@online-pharmacy4u.co.uk'
                    ],
                    "billing" => [
                        "address" => [
                            "fullName" => ($order['shipping_details']['firstName']) ? $order['shipping_details']['firstName'] . ' ' . $order['shipping_details']['lastName'] : $order['user']['name'],
                            "companyName" => null,
                            "addressLine1" => $order['shipping_details']['address'] ?? $order['user']['address'],
                            "addressLine2" => $order['shipping_details']['address2'] ?? '',
                            "addressLine3" => null,
                            "city" => $order['shipping_details']['city'] ?? $order['user']['city'],
                            "county" => "United Kingdom",
                            "postcode" => $order['shipping_details']['zip_code'] ?? $order['user']['zip_code'],
                            "countryCode" => "GB"
                        ],
                        "phoneNumber" => $order['shipping_details']['phone'] ?? $order['user']['phone'],
                        "emailAddress" => $order['shipping_details']['email'] ?? $order['user']['email']
                    ],
                    "packages" => [
                        [
                            "weightInGrams" => $order['weight'],
                            "packageFormatIdentifier" => "parcel",
                            "customPackageFormatIdentifier" => "",
                            "dimensions" => [
                                "heightInMms" => 10,
                                "widthInMms" => 20,
                                "depthInMms" => 30
                            ],
                            "contents" => $content
                        ]
                    ],
                    "orderDate" => $order['created_at'],
                    "plannedDespatchDate" => null,
                    "specialInstructions" => $order['note'],
                    "subtotal" => $order['total_ammount'] - $order['shipping_details']['cost'],
                    "shippingCostCharged" => $order['shipping_details']['cost'],
                    "otherCosts" => 0,
                    "customsDutyCosts" => null,
                    "total" => $order['total_ammount'],
                    "currencyCode" => "GBP",
                    "postageDetails" => [
                        "sendNotificationsTo" => "billing",
                        "consequentialLoss" => 0,
                        "receiveEmailNotification" => true,
                        "receiveSmsNotification" => true,
                        "guaranteedSaturdayDelivery" => false,
                        "requestSignatureUponDelivery" => true,
                        "isLocalCollect" => null,
                        "safePlace" => null,
                        "department" => null,
                        "AIRNumber" => null,
                        "IOSSNumber" => null,
                        "requiresExportLicense" => true,
                        "commercialInvoiceNumber" => null,
                        "commercialInvoiceDate" => null
                    ],
                    "label" => [
                        "includeLabelInResponse" => false,
                        "includeCN" => false,
                        "includeReturnsLabel" => false
                    ],
                    "orderTax" => 0
                ]
            ]
        ];
        return $payload;
    }

//    private function get_prev_orders($orders)
//    {
//        $emails = array_unique(Arr::pluck($orders, 'email'));
//        $prev_orders = Order::select('email', DB::raw('count(*) as total_orders'))
//            ->whereIn('email', $emails)->where('payment_status', 'Paid')
//            ->groupBy('email')->get()->sortBy('email')->values()->keyBy('email')->toArray();
//        return $prev_orders;
//    }

    private function get_prev_orders($orders)
    {
        $order_ids = Arr::pluck($orders, 'id');
        $emails = Order::whereIn('id', $order_ids)
            ->with('shippingdetails')
            ->get()
            ->pluck('shippingdetails.email')
            ->unique()
            ->toArray();

        $prev_orders = Order::with('shippingdetails')
            ->select('shipping_details.email', DB::raw('count(orders.id) as total_orders'))
            ->join('shipping_details', 'orders.id', '=', 'shipping_details.order_id')
            ->whereIn('shipping_details.email', $emails)
            ->where('orders.payment_status', 'Paid')
            ->groupBy('shipping_details.email')
            ->get()
            ->sortBy('shipping_details.email')
            ->values()
            ->keyBy('shipping_details.email')
            ->toArray();
        $prev_orders = array_values($prev_orders);

        return $prev_orders;
    }


    private function assign_order_types($orders)
{
            foreach ($orders as &$order) {
                // Convert orderdetails back to a Collection if it's an array
                $orderDetailsCollection = collect($order['orderdetails']);  // Convert to a Collection
        
                // Now you can safely use pluck on the Collection
                $consultationTypes = $orderDetailsCollection->pluck('consultation_type')->toArray();

            if (in_array('premd', $consultationTypes)) {
                $order['order_type'] = 'premd';
            } elseif (in_array('pmd', $consultationTypes)) {
                $order['order_type'] = 'pmd';
            } 
            elseif (in_array('premd/Reorder', $consultationTypes)) {
                $order['order_type'] = 'premd/Reorder';
            } else {
                $order['order_type'] = 'one_over';
            }

            $order['consultation_types'] = $consultationTypes;
        }
        return $orders;
    }

    // comments
    public function comments(Request $request)
    {
        try {
            $data = Comment::where(['comment_for' => 'Orders', 'comment_for_id' => $request->id])->get()->toArray();
            $message = 'Comments retirved  successfully';

            return response()->json(['status' => 'success', 'message' => $message, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error geting comments', 'error' => $e->getMessage()], 500);
        }
    }

    public function comment_store(Request $request): JsonResponse
    {
        $this->authorize('comment_store');

        try {

            $comment = new Comment();
            $comment->comment_for = 'Orders';
            $comment->comment_for_id = $request->comment_for_id;
            $comment->user_id = Auth::user()->id;
            $comment->user_name = Auth::user()->name;
            $comment->user_pic = (Auth::user()->user_pic) ? asset('storage/' . Auth::user()->user_pic) : asset('assets/admin/img/profile-img1.png');
            $comment->comment = $request->comment;
            $comment->created_by = Auth::id();;
            $save = $comment->save();

            $message = 'Comment added successfully';
            return response()->json(['status' => 'success', 'message' => $message, 'data' => $save]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Error storing Invoice', 'error' => $e->getMessage()], 500);
        }
    }

    public function update_additional_note(UpdateAdditionalNoteRequest $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('orders_received');

        $updateData = [
            'note' => $request->note,
            'updated_by' => $user->id,
        ];

        $response = Order::where('id', $request->order_id)->update($updateData);

        $message = "Data updated Successfully";
        if ($response) {
            return redirect()->route('admin.orderDetail', ['id' => base64_encode($request->order_id)])->with(['msg' => $message]);
        }

        return redirect()->back()->withErrors(['error' => 'Failed to update the note']);
    }

    public function update_shipping_address(Request $request)
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('orders_received');

        $updateData = [];
        if ($request->city) {
            $updateData['city'] = $request->city;
        }

        if ($request->postal_code) {
            $updateData['zip_code'] = $request->postal_code;
        }

        if ($request->address1) {
            $updateData['address'] = $request->address1;
        }

        if ($request->address2) {
            $updateData['address2'] = $request->address2;
        }

        if ($request->city || $request->postal_code || $request->address1 || $request->address2) {
            $updateData['updated_by'] = $data['user']->id;
            $response = ShippingDetail::where('order_id', $request->order_id)->update($updateData);
            $message = "Data updated Successfully";
        } else {
            $message = "No data Received for update";
        }

        return redirect()->route('admin.orderDetail', ['id' => base64_encode($request->order_id)])->with(['msg' => $message]);
    }

    public function gp_locations()
    {
        $user = $this->getAuthUser();
        $this->authorize('gp_locations');

        $data['user'] = $user;

        if ($user->hasRole('super_admin')) {
            $data['gp_locations'] = Pharmacy4uGpLocation::where('status', 'Active')->latest('id')->get()->toArray();
        }

        return view('admin.pages.questions.gp_locations', $data);
    }

    public function Add_PMedQuestion(request $request)
    {
        $this->authorize('add_question');
        $data['user'] = $this->getAuthUser();
        if ($request->has('id')) {
            $data['question'] = PMedGeneralQuestion::findOrFail($request->id)->toArray();
        }
        return view('admin.pages.questions.Create_p_med_question', $data);
    }

    public function get_PMeddp_questions()
    {

        $result['dp_qstn'] = PMedGeneralQuestion::select('id', 'title')
            ->where(['is_dependent' => 'yes', 'status' => 'Active'])
            ->orderBy('id')
            ->pluck('title', 'id')
            ->toArray();
        if ($result['dp_qstn']) {
            return response()->json(['status' => 'success', 'result' => $result]);
        } else {
            return response()->json(['status' => 'empty', 'result' => []]);
        }
    }

    public function create_PMedQuestion(StorePmedQuestionRequest $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('add_question');

        $question = PMedGeneralQuestion::updateOrCreate(
            ['id' => $request->id ?? null],
            [
                'title' => ucwords($request->title),
                'desc' => $request->desc ?? null,
                'is_assigned' => $request->is_assigned,
                'anwser_set' => $request->anwser_set,
                'type' => $request->type,
                'yes_lable' => ucwords($request->yes_lable) ?? null,
                'no_lable' => ucwords($request->no_lable) ?? null,
                'optA' => ucwords($request->optA) ?? null,
                'optB' => ucwords($request->optB) ?? null,
                'optC' => ucwords($request->optC) ?? null,
                'optD' => ucwords($request->optD) ?? null,
                'order' => $request->order ?? 0,
                'is_dependent' => ($request->type == 'non_dependent') ? 'no' : 'yes',
                'created_by' => $user->id,
            ]
        );

        if ($question->id) {
            if ($question->is_assigned == 'yes') {
                $options = ['optA', 'optB', 'optC', 'optD', 'optY', 'optN', 'openBox', 'file'];

                foreach ($options as $option) {
                    $value = $request->next_quest[$option];
                    $selector = 'nothing';

                    if ($value['next_type'] == 'alert') {
                        $alert = Alert::updateOrCreate(
                            [
                                'type' => $value['alert_type'],
                                'body' => $value['alert_msg'],
                                'route' => 'web.productQuestion',
                                'option' => $option,
                                'question_id' => $question->id,
                                'question_type' => 'PMedGeneralQuestion',
                                'created_by' => $user->id,
                            ]
                        );

                        if ($alert->id) {
                            $selector = $alert->id;

                            $mapped = QuestionMapping::updateOrCreate(
                                [
                                    'question_id' => $question->id,
                                    'category_id' => '0',
                                    'answer' => $option,
                                    'next_type' => 'alert',
                                    'selector' => $alert->id,
                                    'status' => 1,
                                    'question_type' => 'PMedGeneralQuestion',
                                    'created_by' => $user->id,
                                ]
                            );
                        } else {
                            dd('alert is not saved');
                        }
                    }

                    if ($value['next_type'] == 'question') {
                        $selector = $value['question'];

                        $mapped = QuestionMapping::updateOrCreate(
                            [
                                'question_id' => $question->id,
                                'category_id' => '0',
                                'answer' => $option,
                                'next_type' => 'question',
                                'selector' => $selector,
                                'status' => 1,
                                'question_type' => 'PMedGeneralQuestion',
                                'created_by' => $user->id,
                            ]
                        );
                    }

                    if ($value['next_type'] == 'nothing') {
                        $mapped = QuestionMapping::updateOrCreate(
                            [
                                'question_id' => $question->id,
                                'category_id' => '0',
                                'answer' => $option,
                                'next_type' => 'nothing',
                                'selector' => $selector,
                                'status' => 1,
                                'question_type' => 'PMedGeneralQuestion',
                                'created_by' => $user->id,
                            ]
                        );
                    }
                }
            }

            $message = "Question " . ($request->id ? "Updated" : "Saved") . " Successfully";
            return redirect()->route('admin.pMedGQ')->with(['msg' => $message]);
        }

        return redirect()->route('admin.pMedGQ');
    }

    public function updateOrder(Request $request)
    {
        $order = $request->input('order');
        foreach ($order as $index => $id) {
            $question = PMedGeneralQuestion::find($id);
            if ($question) {
                $question->order = $index + 1;
                $question->save();
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function deletePMedQuestion(DeletePMedQuestionRequest $request)
    {
        $question = PMedGeneralQuestion::find($request->id);
        $question->delete();

        return redirect()->route('admin.pMedGQ')->with('success', 'Question deleted successfully');
    }


    public function Add_PrescriptionMedQuestion(Request $request)
    {
        $this->authorize('add_question');
        $data['user'] = $this->getAuthUser();
        if ($request->has('id')) {
            $data['question'] = PrescriptionMedGeneralQuestion::findOrFail($request->id)->toArray();
        }

        return view('admin.pages.questions.Create_prescription_med_question', $data);
    }

    public function get_PrescriptionMeddp_questions()
    {
        $result['dp_qstn'] = PrescriptionMedGeneralQuestion::select('id', 'title')
            ->where(['is_dependent' => 'yes', 'status' => 'Active'])
            ->orderBy('id')
            ->pluck('title', 'id')
            ->toArray();
        if ($result['dp_qstn']) {
            return response()->json(['status' => 'success', 'result' => $result]);
        } else {
            return response()->json(['status' => 'empty', 'result' => []]);
        }
    }

    public function create_PrescriptionMedQuestion(CreatePrescriptionMedQuestionRequest $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('add_question');

        $question = PrescriptionMedGeneralQuestion::updateOrCreate(
            ['id' => $request->id ?? NULL],
            [
                'title' => ucwords($request->title),
                'desc' => $request->desc ?? NULL,
                'is_assigned' => $request->is_assigned,
                'anwser_set' => $request->anwser_set,
                'type' => $request->type,
                'yes_lable' => ucwords($request->yes_lable) ?? NULL,
                'no_lable' => ucwords($request->no_lable) ?? NULL,
                'optA' => ucwords($request->optA) ?? NULL,
                'optB' => ucwords($request->optB) ?? NULL,
                'optC' => ucwords($request->optC) ?? NULL,
                'optD' => ucwords($request->optD) ?? NULL,
                'order' => $request->order ?? 0,
                'is_dependent' => ($request->type == 'non_dependent') ? 'no' : 'yes',
                'created_by' => $user->id,
            ]
        );

        if ($question->id) {
            if ($question->is_assigned == 'yes') {
                $options = ['optA', 'optB', 'optC', 'optD', 'optY', 'optN', 'openBox', 'file'];

                foreach ($options as $option) {
                    $value = $request->next_quest[$option];
                    $selector = 'nothing';

                    if ($value['next_type'] == 'alert') {
                        $alert = Alert::updateOrCreate(
                            [
                                'type' => $value['alert_type'],
                                'body' => $value['alert_msg'],
                                'route' => 'web.productQuestion',
                                'option' => $option,
                                'question_id' => $question->id,
                                'question_type' => 'PrescriptionMedGeneralQuestion',
                                'created_by' => $user->id
                            ]
                        );

                        if ($alert->id) {
                            $selector = $alert->id;

                            QuestionMapping::updateOrCreate(
                                [
                                    'question_id' => $question->id,
                                    'category_id' => '0',
                                    'answer' => $option,
                                    'next_type' => 'alert',
                                    'selector' => $alert->id,
                                    'status' => 1,
                                    'question_type' => 'PrescriptionMedGeneralQuestion',
                                    'created_by' => $user->id
                                ]
                            );
                        } else {
                            dd('alert is not saved');
                        }
                    }

                    if ($value['next_type'] == 'question') {
                        $selector = $value['question'];
                        QuestionMapping::updateOrCreate(
                            [
                                'question_id' => $question->id,
                                'category_id' => '0',
                                'answer' => $option,
                                'next_type' => 'question',
                                'selector' => $selector,
                                'status' => 1,
                                'question_type' => 'PrescriptionMedGeneralQuestion',
                                'created_by' => $user->id
                            ]
                        );
                    }

                    if ($value['next_type'] == 'nothing') {
                        QuestionMapping::updateOrCreate(
                            [
                                'question_id' => $question->id,
                                'category_id' => '0',
                                'answer' => $option,
                                'next_type' => 'nothing',
                                'selector' => $selector,
                                'status' => 1,
                                'question_type' => 'PrescriptionMedGeneralQuestion',
                                'created_by' => $user->id
                            ]
                        );
                    }
                }
            }

            $message = "Question " . ($request->id ? "Updated" : "Saved") . " Successfully";
            return redirect()->route('admin.prescriptionMedGQ')->with(['msg' => $message]);
        }
    }

    public function updatePrescriptionQuestionOrder(Request $request)
    {
        $order = $request->input('order');
        foreach ($order as $index => $id) {
            $question = PrescriptionMedGeneralQuestion::find($id);
            if ($question) {
                $question->order = $index + 1;
                $question->save();
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function deletePrescriptionMedQuestion(Request $request)
    {
        $question = PrescriptionMedGeneralQuestion::find($request->id);
        if (!$question) {
            return redirect()->back()->with('error', 'Question not found');
        }
        $question->delete();

        return redirect()->route('admin.prescriptionMedGQ')->with('success', 'Question deleted successfully');
    }
    public function exportDoctorsApprovalCSV()
    {
        // Fetch all relevant orders with related data
        $orders = Order::with([
            'user:id,name',
            'approved_by:id,name', 
            'shippingDetails:id,order_id,zip_code,city', 
            'orderdetails:id,order_id,product_id,product_status,variant_id,consultation_type,product_qty',
            'orderdetails.product:id,title',
            'orderdetails.variant:id,value'
        ])
        ->where(['payment_status' => 'Paid', 'order_for' => 'doctor'])
        ->latest('created_at')
        ->get();
    
        // Create CSV writer instance
        $csv = Writer::createFromFileObject(new SplTempFileObject());
    
        // Add CSV header
        $csv->insertOne([
            'Order ID', 'User Name', 'Product Name', 'Variant Details', 'Zip Code', 'City', 'Consultation Type', 'Status', 'Quantity'
        ]);
    
        // Loop through orders and write data to CSV
        foreach ($orders as $order) {
            foreach ($order->orderdetails as $orderDetail) {
                $csv->insertOne([
                    $order->id,
                    $order->user->name ?? 'N/A',
                    $orderDetail->product->title ?? 'N/A',
                    $orderDetail->variant->value ?? 'N/A',
                    $order->shippingDetails->zip_code ?? 'N/A',
                    $order->shippingDetails->city ?? 'N/A',
                    $orderDetail->consultation_type ?? 'N/A',
                    $order->status ?? 'N/A',
                    $orderDetail->product_qty ?? 'N/A',
                ]);
            }
        }
    
        // Return the CSV as a downloadable file
        return response()->stream(function () use ($csv) {
            $csv->output('orders.csv');
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="orders.csv"',
        ]);
    }
       
    public function exportOrdersCSV(Request $request)
    {
        // Get the filters from the request
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $address = $request->input('address');
        $postalCode = $request->input('postalCode');
        $product = $request->input('product');
        $status = $request->input('status');
    
        // Build the query
        $query = Order::with([
            'user', 
            'shippingDetail:id,order_id,firstName,lastName,zip_code,email', 
            'orderdetails:id,order_id,product_id,product_qty', 
            'orderdetails.product:id,title', 
        ])
        ->where(['payment_status' => 'Paid', 'status' => 'Shipped']);
        
        // Apply filters
        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }
    
        if ($address && $address !== 'All') {
            $query->whereHas('shippingDetail', function($q) use ($address) {
                $q->where('address', 'like', '%' . $address . '%');
            });
        }
    
        if ($postalCode && $postalCode !== 'All') {
            $query->whereHas('shippingDetail', function($q) use ($postalCode) {
                $q->where('zip_code', 'like', '%' . $postalCode . '%');
            });
        }
    
        if ($product && $product !== 'All') {
            $query->whereHas('orderdetails.product', function($q) use ($product) {
                $q->where('title', 'like', '%' . $product . '%');
            });
        }
    
        if ($status && $status !== 'All') {
            $query->where('status', $status);
        }
    
        // Fetch filtered orders
        $orders = $query->latest('created_at')->get();
    
        // Create CSV writer instance
        $csv = Writer::createFromFileObject(new SplTempFileObject());
    
        // Add CSV header
        $csv->insertOne([
            'Zip Code', 'Date/Time', 'Shipping Full Name', 'Order No', 'Product Name', 'Email', 'Quantity',
        ]);
    
        // Add order data
        foreach ($orders as $order) {
            // Fetch shipping details
            $zipCode = $order->shippingDetail->zip_code ?? 'N/A';
            $email = $order->shippingDetail->email ?? 'N/A'; 
            $firstName = $order->shippingDetail->firstName ?? 'N/A';
            $lastName = $order->shippingDetail->lastName ?? 'N/A'; 
            // $customerName = $order->user->name ?? 'N/A'; 
            $orderId = $order->id;
            $orderDate = $order->created_at->format('Y-m-d H:i:s'); // Date/Time in desired format
    
            // Iterate over order details and sum the quantities for each product
            $productQuantities = [];
    
            foreach ($order->orderdetails as $detail) {
                $productId = $detail->product_id; 
                $quantity = $detail->product_qty ?? 1; 
                
                // Sum quantities by product ID
                if (!isset($productQuantities[$productId])) {
                    $productQuantities[$productId] = 0;
                }
                $productQuantities[$productId] += $quantity;
            }
    
            // Iterate through the product quantities and insert data into the CSV
            foreach ($productQuantities as $productId => $totalQuantity) {
                // Fetch product name from the loaded 'product' relationship
                $productName = $order->orderdetails->firstWhere('product_id', $productId)->product->title ?? 'N/A';
    
                // Combine first and last name to form the full name
                $fullName = $firstName . ' ' . $lastName;
    
                $csv->insertOne([
                    $zipCode,
                    $orderDate,
                    $fullName ,
                 //   $customerName,
                    $orderId,
                    $productName,
                    $email,
                    $totalQuantity,
                ]);
            }
        }
    
        // Prepare the CSV for download
        $csvData = $csv->toString();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="audit_orders.csv"',
        ];
    
        return Response::make($csvData, 200, $headers);
    }
    




}
