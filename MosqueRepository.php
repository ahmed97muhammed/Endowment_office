<?php 
namespace App\Repositories;
use App\Mosque;
use App\MosqueWaqf;
use App\MosqueAttachment;
use Validator;
use DB;
use Alkoumi\LaravelHijriDate\Hijri;
use GeniusTS\HijriDate\Date;
class MosqueRepository implements MosqueRepositoryInterface
{
    public function getMosques()
    {
        return Mosque::with('getwaqfes')->get();
    }
  
    public function getMosque($id)
    {
        return Mosque::findOrFail($id);
    }

    public function createMosque($mosque)
    {
        $validation = Validator::make($mosque,[
        'mosque_name'=>['required'],
        ]);
        return $validation->passes()?Mosque::create($mosque):response()->json('error',500);
    }

    public function updateMosque($mosque,$id)
    {
        $validation = Validator::make($mosque,[
        'mosque_name'=>['required'],
        ]);
        return $validation->passes()?Mosque::findOrFail($id)->update($mosque):response()->json('error',500);
    }

    public function deleteMosque($id)
    {
        return Mosque::findOrFail($id)->delete();
    }

    public function convertfromhijritigeroian($hijri_date)
    {
        $text_hijri_date=explode('-',$hijri_date);
        $year=$text_hijri_date[0];
        $month=$text_hijri_date[1];
        $day=$text_hijri_date[2];
        \GeniusTS\HijriDate\Date::setToStringFormat('Y-m-d');
        $get_geroian = \GeniusTS\HijriDate\Hijri::convertToGregorian($day,$month,$year);
        $geroian_date=$get_geroian->format("Y-m-d");
        return $geroian_date;
    }

    public function getMosqueWaqfes($mosque_id)
    {
        return MosqueWaqf::where("related_mosque_id",$mosque_id)->get();
    }


    public function deleteMosqueWaqf($waqf_id)
    {
        return MosqueWaqf::findOrFail($waqf_id)->delete();
    }

    public function updateMosqueWaqf($waqf,$waqf_id)
    {
        $validation = Validator::make($waqf, [
        'waqf_number' => ['nullable','numeric'],
        'waqf_rent_value'=>['nullable','numeric'],
        ]);
        return $validation->passes()?MosqueWaqf::find($waqf_id):response()->json('error',500);
    }

    public function getMosqueAttachs($mosque_id)
    {
        return MosqueAttachment::where("att_related_mosque_id",$mosque_id)->get();
    }

    public function deleteMosqueAttach($attch_id)
    {
        return MosqueAttachment::findOrFail($attch_id)->delete();
    }

    public function getAttach($attch_id)
    {
        return MosqueAttachment::findOrFail($attch_id);
    }

    public function getMosqueWaqf($attch_id)
    {
        return MosqueWaqf::findOrFail($attch_id);
    }

    public function createMosqueAttach($attach)
    {
        $validation = Validator::make($attach, [
            'att_type'=>['required'],
            'att_name'=>['required'],
        ]);
        return $validation->passes()?MosqueAttachment::create($attach):response()->json('error',500);
    }

    public function deletePermission()
    {
        $user=auth()->user();
        return $permission_check=($user->getUserRoles->can_delete=="1")?true:false;
    }

    public function createPermission()
    {
        $user=auth()->user();
        return $permission_check=($user->getUserRoles->can_add=="1")?true:false;
    }

    public function updatePermission()
    {
        $user=auth()->user();
        return $permission_check=($user->getUserRoles->can_edit=="1")?true:false;
    }

    public function printPermission()
    {
        $user=auth()->user();
        return $permission_check=($user->getUserRoles->can_print=="1")?true:false;
    }

    public function filterMosques($criteria,$inputval)
    {
        return Mosque::where($criteria,'like','%'.$inputval.'%')->get();
    }

    public function MosquesWithiMaamMoazenSkn()
    {
        return Mosque::Where("exist_residence_to_emam","نعم")->Where("exist_residence_to_moazen","نعم")->get();
    }

    public function MosquesHasWaqfes()
    {
        return Mosque::whereHas("getwaqfes")->get();
    }

    public function MosquesHasWaqfesByName($mosque_type,$mosque_name)
    {
        return DB::table('mosques')
            ->join("mosque_waqfs","mosques.id","related_mosque_id")
            ->where("mosque_type",$mosque_type)
            ->where("mosque_name",$mosque_name)->get();
    }

}
