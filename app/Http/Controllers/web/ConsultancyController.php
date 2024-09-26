<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Pharmacy4uGpLocation;
use App\Models\PMedGeneralQuestion;
use App\Models\PrescriptionMedGeneralQuestion;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\Consultancy\UpdateIdDocumentRequest;
use Illuminate\Support\Facades\Session;

class ConsultancyController extends Controller
{
    private $menu_categories;
    protected $status;
    protected $ENV;
    public function consultationForm(Request $request)
    {
        $data['user'] = auth()->user() ?? [];
        $data['template'] = $request->template ?? session('template');
        $data['product_id'] = $request->product_id ?? session('product_id');
        if ($data['template'] == config('constants.PHARMACY_MEDECINE')) {
            $data['questions'] = PMedGeneralQuestion::where(['status' => 'Active'])->get()->toArray();
            return view('web.pages.pmd_genral_question', $data);
        } else if ($data['template'] == config('constants.PRESCRIPTION_MEDICINE')) {
            if (auth()->user()) {
                if ($data['user']->id_document ?? Null) {
                    foreach (session('consultations') ?? [] as $key => $value) {
                        if ($key == $data['product_id'] || strpos($key, ',') !== false && in_array($data['product_id'], explode(',', $key))) {
                            if (isset(session('consultations')[$key]) && session('consultations')[$key]['gen_quest_ans'] != '') {
                                return redirect()->route('web.productQuestion', ['id' => $key]);
                                break;
                            }
                        }
                    }

                    $data['questions'] = PrescriptionMedGeneralQuestion::where(['status' => 'Active'])->get()->toArray();
                    $data['gp_locations'] = Pharmacy4uGpLocation::where('status', 'Active')->latest('id')->get()->toArray();
                    return view('web.pages.premd_genral_question', $data);
                } else {
                    session()->put('intended_url', 'fromConsultation');
                    session()->put('template', $data['template']);
                    session()->put('product_id', $data['product_id']);
                    return redirect()->route('web.idDocumentForm');
                }
            } else {
                session()->put('intended_url', 'fromConsultation');
                session()->put('template', $data['template']);
                session()->put('product_id', $data['product_id']);
                return redirect()->route('login');
            }
        } else {
            return redirect()->back();
        }
    }

    public function idDocumentForm()
    {
        $user = auth()->user();
        if ($user->id_document ?? Null) {
            return redirect()->back();
        } else {
            return view('web.pages.id_document_form', [$user]);
        }
    }
    public function idDocumentUpdate(UpdateIdDocumentRequest $request)
    {
        $user = auth()->user();

        // If validation passes, handle file upload
        if ($request->hasFile('id_document')) {
            $doc = $request->file('id_document');
            $docName = uniqid() . time() . '_' . $doc->getClientOriginalName();
            $doc->storeAs('user_docs', $docName, 'public');
            $docPath = 'user_docs/' . $docName;

            // Update user's ID document path
            $user->update([
                'id_document' => $docPath,
            ]);
        }

        return redirect()->route('web.consultationForm');
    }

    public function consultationStore(Request $request)
    {
        $consultations = Session::get('consultations', []);
        $questionAnswers = [];
        foreach ($request->all() as $key => $value) {
            if ($key === '_token' || $key === 'template') {
                continue;
            }
            if (strpos($key, 'quest_') === 0) {
                $question_id = substr($key, 6);
                $questionAnswers[$question_id] = $value;
            }
        }

        $consultationData = [];
        if ($request->template == config('constants.PHARMACY_MEDECINE')) {
            $consultationData = ['type' => 'pmd', 'product_id' => $request->product_id, 'gen_quest_ans' => $questionAnswers, 'pro_quest_ans' => ''];
        } else {
            $product_ids = explode(',', $request->product_id);
            $category = Product::with('category', 'sub_cat', 'child_cat')->where('status', $this->status['Active'])->find($product_ids[0]);
            $slug = ['main_category' => $category->category->slug, 'sub_category' => $category->sub_cat->slug ?? null, 'child_category' => $category->child_cat->slug ?? null];
            $consultationData = ['type' => 'premd', 'product_id' => $request->product_id, 'slug' => $slug, 'gen_quest_ans' => $questionAnswers, 'pro_quest_ans' => ''];
        }

        if ($request->template == config('constants.PHARMACY_MEDECINE')) {
            $consultations[$request->product_id] = $consultationData;
            Session::put('consultations', $consultations);
            $prod = Product::findOrFail($request->product_id);
            return redirect()->route('web.product', ['id' => $prod->slug]);
        } else {
            $consultations[$request->product_id] = $consultationData;
            Session::put('consultations', $consultations);
            return redirect()->route('web.productQuestion', ['id' => $request->product_id]);
        }
    }

    public function transactionStore(Request $request)
    {
        if (auth()->user()) {
            if (isset(session('consultations')[$request->product_id])) {
                $productSession = session('consultations')[$request->product_id];
                $generic_consultation = isset($productSession['gen_quest_ans']);

                if ($generic_consultation) {
                    $questionAnswers = [];
                    foreach ($request->all() as $key => $value) {
                        if ($key === '_token' || $key === 'template') {
                            continue;
                        }
                        if (strpos($key, 'quest_') === 0) {
                            $question_id = substr($key, 6);
                            $questionAnswers[$question_id] = $value;
                        } else if (strpos($key, 'qfid_') === 0) {
                            $question_id = substr($key, 5);
                            if ($request->hasFile($key)) {
                                $file = $request->file($key);
                                $fileName = time() . '_' . uniqid('', true) . '.' . $file->getClientOriginalExtension();
                                $file->storeAs('consultation/product', $fileName, 'public');
                                $filePath = 'consultation/product/' . $fileName;
                                $questionAnswers[$question_id] = $filePath;
                            }
                        }
                    }

                    $productSession['pro_quest_ans'] = $questionAnswers;
                    session(['consultations.' . $request->product_id => $productSession]);
                    $slug = session('consultations')[$request->product_id]['slug'];
                    return redirect()->route('category.products', $slug);
                } else {
                    return redirect()->route('shop');
                }
            } else {
                return redirect()->route('shop');
            }
        } else {
            session()->put('intended_url', 'fromConsultation');
            return redirect()->route('login');
        }
    }

}
