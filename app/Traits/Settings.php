<?php

namespace App\Traits;

use App\Setting;
use App\ExtraCost;
use App\HfooterText;
use App\PaymentTerm;
use App\ReportLabel;

use Illuminate\Http\Request;

trait Settings
{
	public function settingsView($id = 0)
    {
        $setting = Setting::findOrFail(1);
        if($id == 0){
            return view("settings")->with(["id"=>$id, "setting"=>$setting, "extras"=>ExtraCost::all(), "hfooters"=>HfooterText::all(), "pterms"=>PaymentTerm::all()]);
        }
        return view("settings")->with(["id"=>$id, "setting"=>$setting, "rlables"=>ReportLabel::all()]);
    }

    public function saveExtraCost(Request $request)
    {
        \Log::Info('saveExtraCost: '.$request->name);
        $request->validate(['name'=>'string|max:255']);
        ExtraCost::create(['name'=>$request->name]);
        return redirect()->route('settings.index', ['id' => 0]);
    }

    public function deleteExtraCost(Request $request)
    {
        \Log::Info('deleteExtraCost: '.$request->id);
        ExtraCost::destroy($request->id);
        return 1;
    }

    public function saveHfooterText(Request $request)
    {
        \Log::Info('saveHfooterText: '.$request->hf_text);
        $request->validate(['hf_text'=>'string|max:255']);
        HfooterText::create(['hf_text'=>$request->hf_text]);
        return redirect()->route('settings.index', ['id' => 0]);
    }

    public function deleteHfooterText(Request $request)
    {
        \Log::Info('deleteHfooterText: '.$request->id);
        HfooterText::destroy($request->id);
        return 1;
    }

    public function savePaymentTerm(Request $request)
    {
        \Log::Info('savePaymentTerm: '.$request->pterm);
        $request->validate(['pterm'=>'string|max:255','shift'=>'numeric']);
        PaymentTerm::create(['pterm'=>$request->pterm, 'shift'=>$request->shift]);
        return redirect()->route('settings.index', ['id' => 0]);
    }

    public function deletePaymentTerm(Request $request)
    {
        \Log::Info('deletePaymentTerm: '.$request->id);
        PaymentTerm::destroy($request->id);
        return 1;
    }

    public function saveReportLabels(Request $request)
    {
        \Log::Info('saveReportLabels');
        $request->validate(['name'=>'string|max:4','value'=>'string|max:50']);
        $id=str_replace('rl','',$request->name);
        ReportLabel::findOrFail($id)->update(['custom'=>$request->value]);
        return 1;
    }

    public function saveCompanySettings(Request $request)
    {
        \Log::Info('saveCompanySettings');
        $cs = ['company_name','company_address','email','sales_tax_reg_no','company_logo','currency','currency_sign','currency_sign_placement','decimal','tax_type','tax1_name','tax1_rate','tax2_name','tax2_rate','print_tax1','print_tax2','tax2_type','print_logo_picture','invoice_prefix', 'starting_invoice_no','invoice_lzcy','invoice_tctext','order_prefix','starting_order_no','order_lzcy','order_tctext','estimate_prefix','starting_estimate_no','estimate_lzcy','estimate_tctext','porder_prefix','starting_porder_no','porder_lzcy','porder_tctext','payments1','payments2','payments3','payments4','payment_receipt_prefix','paid_image','pay_image'];
        $csvld = ['string|max:255','string|max:255','string|max:255','string|max:255','string|max:65536','string|max:3','string|max:1','numeric|non_fraction|tinyInteger','string|max:1','numeric|non_fraction|tinyInteger','string|max:32','numeric|non_fraction|tinyInteger','string|max:32','numeric|non_fraction|tinyInteger','boolean','boolean','numeric|non_fraction|tinyInteger','boolean','string|max:32','numeric|non_fraction|integer_custom_unsigned','boolean','string|max:65536','string|max:32','numeric|non_fraction|integer_custom_unsigned','boolean','string|max:65536','string|max:32','numeric|non_fraction|integer_custom_unsigned','boolean','string|max:65536','string|max:32','numeric|non_fraction|integer_custom_unsigned','boolean','string|max:65536','boolean','boolean','boolean','boolean','string|max:32','string|max:65536','string|max:65536'];
        $i=0;
        foreach ($cs as $csv) {
            if(isset($request->{$csv})){
                $request->validate([$csv => $csvld[$i]]);
                Setting::findOrFail(1)->update([$csv => $request->{$csv}]);
                if($csv !== 'currency'){return 1;}
            }
            $i++;
        }
        return 1;
    }
}