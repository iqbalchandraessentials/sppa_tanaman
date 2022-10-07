<?php

use App\Models\Backend\Access\Position\Position;
use App\Models\Backend\Access\UserDetail\UserDetail;
use App\Models\Backend\Frontend\Letter\Letter;
use App\Models\Backend\Frontend\Letter\LetterHistory;
use App\Models\Backend\Frontend\Letter\LetterReview;
use App\Models\Backend\Frontend\Letter\LetterStatus;
use App\Models\Frontend\Agenda\History\AgendaHistory;
use App\Models\LetterIn\External\External;
use App\Models\Sdm\Honorary;
use App\Models\Seqno;
use App\Models\Sppa\Client\Client;
use App\Models\Sppa\Product\Product;
use App\Models\User;
use Carbon\Carbon;
use Laravolt\Avatar\Avatar;
use Illuminate\Support\Facades\DB;

if (!function_exists('includeRouteFiles')) {

    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function includeRouteFiles($folder)
    {
        $directory = $folder;
        $handle = opendir($directory);
        $directory_list = [$directory];

        while (false !== ($filename = readdir($handle))) {
            if ($filename != '.' && $filename != '..' && is_dir($directory . $filename)) {
                array_push($directory_list, $directory . $filename . '/');
            }
        }

        foreach ($directory_list as $directory) {
            foreach (glob($directory . '*.php') as $filename) {
                require $filename;
            }
        }
    }
}

if (!function_exists('access')) {
    /**
     * Access (lol) the Access:: facade as a simple function.
     */
    function access()
    {
        return app('laratrust');
    }
}

if (!function_exists('createNumber')) {
    function createNumber($lno, $add, $type, $digits, $year)
    {
        $find = Seqno::where('lno', '=', $lno)->where('type', '=', $type)->where('year', $year)->first();

        if ($find == null) {
            $data = array(
                'lno'   => $lno, 'cno' => 1, 'type' => $type, 'year' => $year,
            );
            Seqno::create($data);
        } else {
            $new = $find["cno"] + 1;
            $update = Seqno::findOrfail($find["id"]);
            $update->cno = $new;
            $update->save();
        }

        $get = Seqno::where('lno', '=', $lno)->where('type', '=', $type)->where('year', $year)->first();
        $no = $get["cno"];
        if ($no >= 1 && $no <= 9) {
            $no = (($digits == 3) ?  '00' . $no . $lno . $add : (($digits == 4) ?  '000' . $no . $lno . $add : (('0000' . $no . $lno . $add))));
        } elseif ($no >= 10 && $no <= 99) {
            $no = (($digits == 3) ?  '0' . $no . $lno . $add : (($digits == 4) ?  '00' . $no . $lno . $add  : (('000' . $no . $lno . $add))));
        } elseif ($no >= 100 && $no <= 999) {
            $no = (($digits == 3) ? '' . $no . $lno . $add : (($digits == 4) ? '0' . $no . $lno . $add : (('00' . $no . $lno . $add))));
        }

        return $no;
    }
}
if (!function_exists('createAgendaNumber')) {
    function createAgendaNumber($lno, $type, $digits)
    {
        $find = Seqno::where('lno', '=', $lno)->where('type', '=', $type)->first();

        if ($find == null) {
            $data = array(
                'lno'   => $lno, 'cno' => 1, 'type' => $type,
            );
            Seqno::create($data);
        } else {
            $new = $find["cno"] + 1;
            $update = Seqno::findOrfail($find["id"]);
            $update->cno = $new;
            $update->save();
        }

        $get = Seqno::where('lno', '=', $lno)->where('type', '=', $type)->first();
        $no = $get["cno"];
        if ($no >= 1 && $no <= 9) {
            $no = (($digits == 3) ?  $lno . '00' . $no : (($digits == 4) ?  $lno . '000)' . $no  : (($lno . '0000' . $no))));
        } elseif ($no >= 10 && $no <= 99) {
            $no = (($digits == 3) ?  $lno . '0' . $no : (($digits == 4) ?  $lno . '00)' . $no  : (($lno . '000' . $no))));
        } elseif ($no >= 100 && $no <= 999) {
            $no = (($digits == 3) ?  $lno . '' . $no : (($digits == 4) ?  $lno . '0)' . $no  : (($lno . '00' . $no))));
        }

        return $no;
    }
}
if (!function_exists('getRomawiInMonth')) {
    function getRomawiInMonth($bln)
    {
        switch ($bln) {
            case 1:
                return "I";
                break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }
}

if (!function_exists('createHistory')) {
    /**
     * create new notification.
     *
     * @param  $message    message you want to show in notification
     * @param  $userId     To Whom You Want To send Notification
     *
     * @return object
     */
    function createHistory($remarks, $id, $ids)
    {
        $history = new LetterHistory();

        return $history->insert([
            'remarks'    => $remarks,
            'letter_id'    => $id,
            'letter_status_id' => $ids,
            'created_at' => Carbon::now(),
        ]);
    }
}
if (!function_exists('createAgendaHistory')) {
    /**
     * create new notification.
     *
     * @param  $message    message you want to show in notification
     * @param  $userId     To Whom You Want To send Notification
     *
     * @return object
     */
    function createAgendaHistory($remarks, $id, $ids)
    {
        $history = new AgendaHistory();

        return $history->insert([
            'remarks'    => $remarks,
            'letter_agenda_id'    => $id,
            'letter_status_id' => $ids,
            'created_at' => Carbon::now(),
        ]);
    }
}
if (!function_exists('getFortmatNumber')) {
    /**
     * create new notification.
     *
     * @param  $message    message you want to show in notification
     * @param  $userId     To Whom You Want To send Notification
     *
     * @return object
     */
    function getFortmatNumber($id)
    {
        $format = new Position();

        return $format->findOrFail($id)->number;
    }
}

if (!function_exists('createMemoNumber')) {
    function createMemoNumber($lno, $type, $digits)
    {
        $find = Seqno::where('lno', '=', $lno)->where('type', '=', $type)->first();

        if ($find == null) {
            $data = array(
                'lno'   => $lno, 'cno' => 1, 'type' => $type,
            );
            Seqno::create($data);
        } else {
            $new = $find["cno"] + 1;
            $update = Seqno::findOrfail($find["id"]);
            $update->cno = $new;
            $update->save();
        }

        $get = Seqno::where('lno', '=', $lno)->where('type', '=', $type)->first();
        $no = $get["cno"];
        if ($no >= 1 && $no <= 9) {
            $no = (($digits == 3) ? $lno . '00' : (($digits == 4) ? $lno . '000' : (($lno . '0000')))) . $no;
        } elseif ($no >= 10 && $no <= 99) {
            $no = (($digits == 3) ? $lno . '0' : (($digits == 4) ? $lno . '00' : (($lno . '000')))) . $no;
        } elseif ($no >= 100 && $no <= 999) {
            $no = (($digits == 3) ? $lno . '' : (($digits == 4) ? $lno . '0' : (($lno . '00')))) . $no;
        }

        return $no;
    }
}

if (!function_exists('getUserByID')) {
    function getUserById($id)
    {
        return User::find($id)->name;
    }
}
if (!function_exists('getUserDetailId')) {
    function getUserDetailID()
    {
        return Auth::user()->getUserInfo()->first()->id;
    }
}
if (!function_exists('getUserDeptId')) {
    function getUserDeptId()
    {
        return Auth::user()->getDepartement()->id;
    }
}

if (!function_exists('getUserDivId')) {
    function getUserDivId()
    {
        return Auth::user()->getDivision()->id;
    }
}

if (!function_exists('getUserPositionId')) {
    function getUserPositionId()
    {
        return Auth::user()->getPosition()->id;
    }
}
if (!function_exists('getSigner')) {
    function getSigner()
    {
        $user = Auth::user();
        $paramSign = [];
        $paramReview = [];
        if ($user->info->distribution_id <> 1) {
            if ($user->getMasterPosition() == "KACAB") {
                $paramSign = [6];
                $paramReview = [6];
            } else if ($user->getMasterPosition() == "KASIE") {
                $paramSign = [6];
                $paramReview = [4];
            } else if ($user->getMasterPosition() == "STAFF") {
                $paramSign = [6];
                $paramReview = [4];
            }
        } else {
            if ($user->getMasterPosition() == "KADIV") {
                $paramSign = [2];
                $paramReview = [2];
            } else if ($user->getMasterPosition() == "KABAG") {
                $paramSign = [2, 3];
                $paramReview = [3];
            } else if ($user->getMasterPosition() == "KASIE") {
                $paramSign = [2, 3];
                $paramReview = [3, 4];
            } else if ($user->getMasterPosition() == "STAFF") {
                $paramSign = [2, 3];
                $paramReview = [3, 4];
            }
        }
        return getSelectorItems(Position::whereIn("id", getListHighLevelPosition())->whereIn('masterposition_id', $paramSign)->get(), 'description');
    }
}
if (!function_exists('getUserPositionName')) {
    function getUserPositionName()
    {
        return Auth::user()->getPosition()->description;
    }
}
if (!function_exists('getPositionById')) {
    function getPositionById($id)
    {
        return Position::find($id)->description;
    }
}
if (!function_exists('getListDepartementActive')) {
    function getListDepartementActive()
    {
        $listDept = Auth::user()->getListDept()->get();
        $ids = [];
        foreach ($listDept as $i) {
            $ids[] = $i->id;
        }
        $listDUser = UserDetail::whereIn("departement_id", $ids)->where('active', 'Y')->get();
        $ids = [];
        foreach ($listDUser as $i) {
            $ids[] = $i->id;
        }
        return $ids;
    }
}
if (!function_exists('getListHighLevelPosition')) {
    function getListHighLevelPosition()
    {
        $listDept = Auth::user()->getListDept()->get();
        $ids = [];
        foreach ($listDept as $i) {
            $ids[] = $i->id;
        }
        $listDUser = UserDetail::whereIn("departement_id", $ids)->where('active', 'Y')->get();
        $ids = [];
        foreach ($listDUser as $i) {
            $ids[] = $i->position_id;
        }
        return $ids;
    }
}
if (!function_exists('getListHighLevelDepartementByDivision')) {
    function getListHighLevelDepartementDivision()
    {
        $listDept = Auth::user()->getListDept()->get();

        $ids = [];
        foreach ($listDept as $i) {
            $ids[] = $i->id;
        }
        $listDUser = UserDetail::whereIn("departement_id", $ids)->where('active', 'Y')->get();
        $ids = [];
        foreach ($listDUser as $i) {
            $ids[] = $i->departement_id;
        }
        return $ids;
    }
}
if (!function_exists('getSelectorItems')) {
    function getSelectorItems($collection, $field_name)
    {
        $items = [];

        foreach ($collection as $model) {
            $items[$model->id] = [
                'id'    => $model->id,
                'name'  => $model->$field_name,
                'model' => $model,
            ];
        }

        foreach ($items as $id => $item) {
            $items[$item['id']] = $item['name'];
        }

        return $items;
    }
}
if (!function_exists('checkerAuthFile')) {
    function checkerAuthFile($model, $id, $type = "memo")
    {
        if ($type == 'memo') {
            return $model->query()->where('letter_id', $id)->where('position_id', getUserPositionId())->count();
        } else if ($type == 'memo_share') {
            return $model->query()->where('letter_recipient_id', $id)->where('position_id', getUserPositionId())->count();
        } else if ($type == 'agenda_forward') {
            return $model->query()->where('letter_agenda_id', $id)->where('position_id', getUserPositionId())->count();
        } else if ($type == 'agenda_share') {
            return $model->query()->where('agenda_forward_id', $id)->where('position_id', getUserPositionId())->count();
        }
    }
}
if (!function_exists('getListDepartementAll')) {
    function getListDepartementAll()
    {
        $listDept = Auth::user()->getListDept()->get();
        $ids = [];
        foreach ($listDept as $i) {
            $ids[] = $i->id;
        }
        $listDUser = UserDetail::whereIn("departement_id", $ids)->get();

        $ids = [];
        foreach ($listDUser as $i) {
            $ids[] = $i->id;
        }
        return $ids;
    }
}

if (!function_exists('getMemoSubmitUnReview')) {
    function getMemoSubmitUnReview($id)
    {
        $status = LetterReview::where('letter_id', $id)->where('position_id', getUserPositionId())->count();
        return (($status > 0) ? true : false);
    }
}
if (!function_exists('getMemoid')) {
    function getMemoId($id)
    {
        $data = Letter::find($id);
        return (($data == null) ? '' : $data->regno);
    }
}

if (!function_exists('getMemoStatus')) {
    function getMemoStatus($id)
    {
        $status = LetterStatus::find($id);
        return $status;
    }
}
if (!function_exists('getBase64ImageSize')) {
    function getBase64ImageSize($base64Image)
    {
        try {
            $size_in_bytes = (int) (strlen(rtrim($base64Image, '=')) * 3 / 4);
            $size_in_kb    = $size_in_bytes / 1024;
            $size_in_mb    = $size_in_kb / 1024;

            return round($size_in_kb, 0) . " Kb";
        } catch (Exception $e) {
            return $e;
        }
    }
}
if (!function_exists('getIp')) {
    function getIp()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }
}

if (!function_exists('getLevel')) {
    function getLevel($id)
    {
        switch ($id) {
            case "1":
                return "Rendah";
                break;
            case 2:
                return "Sedang";
                break;
            case 3:
                return "Tinggi";
                break;
            case 4:
                return "Sangat Tinggi";
                break;
        }
    }
}

if (!function_exists('getClientByApiKey')) {
    function getClientByApiKey($apiKey)
    {
        return Client::where('api_key', $apiKey)->first();
    }
}
if (!function_exists('getClientById')) {
    function getClientById($id)
    {
        return Client::find($id);
    }
}

if (!function_exists('getProduct')) {
    function getProduct($product)
    {
        return Product::where('product_code', $product)->first();
    }
}

if (!function_exists('getProductId')) {
    function getProductId($id)
    {
        return Product::find($id);
    }
}
if (!function_exists('getSppaStatus')) {
    function getSppaStatus($status)
    {
        switch ($status) {
            case "W":
                return '<span class="badge badge-secondary">Waiting</span>';
                break;
            case "Y":
                return '<span class="badge badge-success">Approved</span>';
                break;
            case "P":
                return '<span class="badge badge-dark">In Process</span>';
                break;
            case "N":
                return '<span class="badge badge-danger">Not Approved</span>';
                break;
        }
    }
}

if (!function_exists('getLetterStatus')) {
    function getLetterStatus($status)
    {
        switch ($status) {
            case "Pending":
                return '<span class="badge badge-secondary">Pending</span>';
                break;
            case "Submit":
                return '<span class="badge badge-success">Submit</span>';
                break;
            case "Revision":
                return '<span class="badge badge-warning">Request Revision</span>';
                break;
            case "Reject":
                return '<span class="badge badge-danger">Reject</span>';
                break;
        }
    }
}
if (!function_exists('formatRupiah')) {
    function formatRupiah($angka, $digit)
    {
        if (is_numeric($angka)) {
            $format_rupiah = number_format($angka, $digit, ',', '.');
            return $format_rupiah;
        }
    }
}
if (!function_exists('cekKabisat')) {
    function cekKabisat($nilai)
    {
        if ($nilai % 400 == 0) {
            return true;
        } else if (($nilai % 4 == 0) && ($nilai % 100 != 0) && ($nilai % 400 != 0)) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('getExternalById')) {
    function getExternalById($id)
    {
        return External::find($id)->name;
    }
}
if (!function_exists('branchListID')) {
    function branchListID($value)
    {
        switch ($value) {
            case "01":
                return 'Inward';
                break;
            case "02":
                return 'Soepomo';
                break;
            case "03":
                return 'Medan';
                break;
            case "04":
                return 'Lampung';
                break;
            case "05":
                return 'Bandung';
                break;
            case "06":
                return 'Semarang';
                break;
            case "07":
                return 'Surabaya';
                break;
            case "08":
                return 'Makassar';
                break;
            case "09":
                return 'Pekanbaru';
                break;
            case "10":
                return 'Solo';
                break;
            case "11":
                return 'Pontianak';
                break;
            case "13":
                return 'Jambi';
                break;
            case "14":
                return 'Cempaka';
                break;
            case "16":
                return 'Palembang';
                break;
            case "20":
                return 'Balikpapan';
                break;
            case "22":
                return 'Khusus';
                break;
            default:
                return 'Nasional';
                break;
        }
    }
}
if (!function_exists('branchListIdColor')) {
    function branchListIdColor($value)
    {
        switch ($value) {
            case "01":
                return "";
                break;
            case "02":
                return "color:#000;background:#fea131;";
                break;
            case "03":
                return "color:#000;background:#fea131;";
                break;
            case "04":
                return "";
                break;
            case "05":
                return "color:#000;background:#fe7f9c;";
                break;
            case "06":
                return "color:#000;background:#ffff00;";
                break;
            case "07":
                return "color:#000;background:#1ce1ce;";
                break;
            case "08":
                return "color:#000;background:#fe7f9c;";
                break;
            case "09":
                return "color:#000;background:#1ce1ce;";
                break;
            case "10":
                return "color:#000;background:#fff68f;";
                break;
            case "11":
                return "";
                break;
            case "13":
                return "";
                break;
            case "14":
                return "color:#000;background:#ffff00;";
                break;
            case "16":
                return "";
                break;
            case "20":
                return "";
                break;
            case "22":
                return "";
                break;
        }
    }
}
if (!function_exists('branchList')) {
    function branchList()
    {
        return [
            'All'    => 'All Branch',
            '01' => 'Head Office',
            '02' => 'Branch Office Jakarta',
            '03' => 'Branch Office Medan',
            '04' => 'Branch Office Bandar Lampung',
            '05' => 'Branch Office Bandung',
            '06' => 'Branch Office Semarang',
            '07' => 'Branch Office Surabaya',
            '08' => 'Branch Office Makassar',
            '09' => 'Branch Office Pekanbaru',
            '10' => 'Branch Office Surakarta',
            '11' => 'Branch Office Pontianak',
            '12' => 'Branch Office Jogjakarta',
            '13' => 'Branch Office Jambi',
            '14' => 'Branch Office Jakarta Cempaka',
            '15' => 'Branch Office Banda Aceh',
            '16' => 'Branch Office Palembang',
            '17' => 'Branch Office Kediri',
            '18' => 'Branch Office Jember',
            '19' => 'Branch Office Cirebon',
            '20' => 'Branch Office Balikpapan',
            '21' => 'Branch Office Tuban',
            '22' => 'Branch Office Jakarta Khusus',
            '23' => 'Branch Office Bekasi',
            '24' => 'Branch Office Pematang Siantar',
            '25' => 'Branch Office Kendari'

        ];
    }
}
if (!function_exists('mBranchList')) {
    function mBranchList()
    {
        return [
            '02' => 'Branch Office Jakarta Soepomo',
            '03' => 'Branch Office Medan',
            '04' => 'Branch Office Bandar Lampung',
            '05' => 'Branch Office Bandung',
            '06' => 'Branch Office Semarang',
            '07' => 'Branch Office Surabaya',
            '08' => 'Branch Office Makassar',
            '09' => 'Branch Office Pekanbaru',
            '11' => 'Branch Office Pontianak',
            '13' => 'Branch Office Jambi',
            '14' => 'Branch Office Jakarta Cempaka',
            '16' => 'Branch Office Palembang',
            '22' => 'Branch Office Jakarta Khusus',
        ];
    }
}

if (!function_exists('dsRefno')) {
    function dsRefno()
    {
        return [
            'OR-2012/2013-DS'   => 'Own Retention 2012/2013 Drying Sheds',
            'QS-2010-DS'        => 'Quota Share 2010 - Drying Sheds',
            'QS-2013-DS'        => 'Quota Share 2013 - Drying Sheds',
            'QS-2014-DS'        => 'Quota Share 2014 - Drying Sheds',
            'QS-2015-DS'        => 'Quota Share 2015 - Drying Sheds',
            'QS-2016-DS'        => 'Quota Share 2016 - Drying Sheds',
            'QS-2017-DS'        => 'Quota Share 2017 - Drying Sheds',
            'QS-2018-DS'        => 'Quota Share 2018 - Drying Sheds',
            'QS-2019-DS'        => 'Quota Share 2019 - Drying Sheds',
            'QS-2020-DS'        => 'Quota Share 2020 - Drying Sheds',
            'QS-2021-DS'        => 'Quota Share 2021 - Drying Sheds',
            'QS-2022-DS'        => 'Quota Share 2022 - Drying Sheds',
        ];
    }
}

if (!function_exists('getMonthName')) {
    function getMonthName($monthNumber)
    {
        return date("F", mktime(0, 0, 0, $monthNumber, 1));
    }
}
if (!function_exists('chekMinus')) {
    function chekMinus($angka)
    {
        $fmt = numfmt_create('en_US', NumberFormatter::DECIMAL);

        if (is_numeric($angka)) {
            if ($angka < 1) {

                return numfmt_format($fmt, $angka);
                //    NumberFormatter::CURRENCY_ACCOUNTING($angka);
            } else {
                return numfmt_format($fmt, $angka);
            }
        }
    }
}

if (!function_exists('isNan')) {
    function isNan($value)
    {
        return (is_nan($value) ? 0 : (is_infinite($value) ? 0 : $value));
    }
}
if (!function_exists('getSysUser')) {
    function getSysUser($param)
    {
        set_time_limit(1800);
        $pdo = DB::connection('sqlsrv')->getPdo();
        $pdo->exec('SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED');

        $test = $pdo->prepare("SELECT NAME FROM SYSUSER WHERE ID='$param'");
        $test->execute();
        $data = $test->fetch(\PDO::FETCH_OBJ);
        return $data->NAME;
    }
}
if (!function_exists('getLOB')) {
    function getLOB()
    {
        set_time_limit(1800);
        $pdo = DB::connection('sqlsrv')->getPdo();
        $pdo->exec('SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED');

        $test = $pdo->prepare("SELECT LOB as id, description from LOB WHERE ALLOWEDF=1");
        $test->execute();
        $data = $test->fetchAll(\PDO::FETCH_OBJ);
        return $data;
    }
}
if (!function_exists('getProfileLOB')) {
    function getProfileLOB($lob)
    {
        set_time_limit(1800);
        $pdo = DB::connection('sqlsrv')->getPdo();
        $pdo->exec('SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED');

        $test = $pdo->prepare("SELECT id, name as description FROM PROFILE WHERE LOB='$lob' ORDER BY NAME ASC");
        $test->execute();
        $data = $test->fetchAll(\PDO::FETCH_OBJ);
        return $data;
    }
}
if (!function_exists('getProfileName')) {
    function getProfileName($id)
    {
        set_time_limit(1800);
        $pdo = DB::connection('sqlsrv')->getPdo();
        $pdo->exec('SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED');

        $test = $pdo->prepare("SELECT NAME FROM PROFILE WHERE ID='$id'");
        $test->execute();
        $data = $test->fetch(\PDO::FETCH_OBJ);
        return $data->NAME;
    }
}

if (!function_exists('getCOB')) {
    function getCOB()
    {
        set_time_limit(1800);
        $pdo = DB::connection('sqlsrv')->getPdo();
        $pdo->exec('SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED');

        $test = $pdo->prepare("SELECT COB as id, DESCRIPTION FROM COB");
        $test->execute();
        $data = $test->fetchAll(\PDO::FETCH_OBJ);
        return $data;
    }
}
if (!function_exists('getTOC')) {
    function getTOC($id)
    {
        set_time_limit(1800);
        $pdo = DB::connection('sqlsrv')->getPdo();
        $pdo->exec('SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED');

        $test = $pdo->prepare("SELECT TOC as id, DESCRIPTION as DESCRIPTION FROM TOC WHERE ALLOWEDF=1 AND COB='$id' ORDER BY TOC ASC");
        $test->execute();
        $data = $test->fetchAll(\PDO::FETCH_OBJ);
        return $data;
    }
}
if (!function_exists('getCOBId')) {
    function getCOBId($id)
    {
        set_time_limit(1800);
        $pdo = DB::connection('sqlsrv')->getPdo();
        $pdo->exec('SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED');
        $test = $pdo->prepare("SELECT DESCRIPTION FROM COB WHERE COB='$id'");
        $test->execute();
        $data = $test->fetch(\PDO::FETCH_OBJ);
        return $data->DESCRIPTION;
    }
}
if (!function_exists('getTOCId')) {
    function getTOCId($id)
    {
        set_time_limit(1800);
        $pdo = DB::connection('sqlsrv')->getPdo();
        $pdo->exec('SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED');

        $test = $pdo->prepare("SELECT DESCRIPTION FROM TOC WHERE TOC='$id'");
        $test->execute();
        $data = $test->fetch(\PDO::FETCH_OBJ);
        return $data->DESCRIPTION;
    }
}
if (!function_exists('getSelectorItems')) {
    function getSelectorItems($collection, $field_name)
    {
        $items = [];

        foreach ($collection as $model) {
            $items[$model->id] = [
                'id'    => $model->id,
                'name'  => $model->$field_name,
                'model' => $model,
            ];
        }

        foreach ($items as $id => $item) {
            $items[$item['id']] = $item['name'];
        }

        return $items;
    }
}
if (!function_exists('getSelectorLob')) {
    function getSelectorLob($collection, $field_name)
    {
        $items = [];

        foreach ($collection as $model) {
            $items[] = [
                'id'    => $model->id,
                'text'  => $model->$field_name . ' - ' . $model->id,
            ];
        }
        return $items;
    }
}

if (!function_exists('segmentName')) {
    function segmentName($val)
    {
        switch ($val) {
            case "MKT1":
                return 'BANK';
                break;
            case "MKT2":
                return 'KORPORASI';
                break;
            case "MKT3":
                return 'RETAIL';
                break;
            default:
                return 'AFILIASI';
                break;
        }
    }
}

if (!function_exists('honoraries')) {
    function honoraries()
    {
        $listDUser = UserDetail::where("departement_id", getUserDeptId())->where('active', 'Y')->get();
        $ids = [];
        foreach ($listDUser as $i) {
            $ids[] = $i->user_id;
        }

        $honor = Honorary::where('type', 'Honorer')->whereIn('user_id', $ids)->get();
        return $honor;
    }
}
if (!function_exists('positionName')) {
    function positionName($id)
    {
        return Position::findOrFail(UserDetail::where('user_id', $id)->where('active', 'Y')->first()->position_id)->description;
    }
}
if (!function_exists('userName')) {
    function userName($id)
    {
        return User::findOrFail($id)->name;
    }
}

if (!function_exists('profileImage')) {
    function profileImage($val)
    {
        // return Avatar::create($val)->toBase64();
    }
}
