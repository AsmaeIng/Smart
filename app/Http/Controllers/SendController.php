<?php

namespace App\Http\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use DB;
use App\Sends;
use App\Headers;
use App\Bodys;
use App\Offres;
use App\Sips;//Sips Domains Servers
use App\Domains;
use App\Servers;
use App\Drops;
use App\File;
use Illuminate\Http\Request;

class SendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $etat="send";
   public function index()
    {
       $data = DB::table('sends')
       ->select('sends.*')
       ->get();
	 
		$pageConfigs = ['bodyCustomClass' => 'app-page menu-collapse'];	
        return view('pages.sends.index', ['pageConfigs' => $pageConfigs],compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
            
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
   
	    
	    $pageConfigs = ['bodyCustomClass' => 'app-page menu-collapse'];
		return view('pages.sends.create', ['pageConfigs' => $pageConfigs]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	  public function store(Request $request ) {		  
		$sends = new Sends();
		$sends->id_isps =  $request['id_isps'];
        $sends->fraction = $request['fraction'];
        $sends->x_delay = $request['x_delay'];
        $sends->seed = $request['seed'];
        $sends->count = $request['count'];        
		$sends->save();
		$pageConfigs = ['bodyCustomClass' => 'app-page menu-collapse'];
        return redirect()->route('sends.index', ['pageConfigs' => $pageConfigs]);

    }	
    /**
     * Display the specified resource.
     *
     * @param  \App\sends  $sends
     * @return \Illuminate\Http\Response
     */
    public function show(Typeliste $sends)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sends  $sends
     * @return \Illuminate\Http\Response
     */
    public function edit($id)//
    {
        $drop = DB::table('drops')
                ->join('offres','offres.id','=','drops.offre_id')
                ->join('headers','headers.id','=','drops.header_id')
                ->join('bodys','bodys.id','=','drops.body_id')
                ->select('drops.*','headers.texte as header','bodys.texte as body','offres.subjects as subject','offres.froms as from')
                ->where('drops.id', $id)->first();
        $tabSubject=explode(" ",$drop->subject);
        $tabFroms=explode(" ",$drop->from);
        //var_dump($tabFroms);
        $pageConfigs = ['bodyCustomClass' => 'app-page menu-collapse'];
		return view('pages.drops.editSend', ['pageConfigs' => $pageConfigs],compact('drop','tabSubject','tabFroms'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sends  $Sends
     * @return \Illuminate\Http\Response
     */			
						
	  public function update(Request $request, $id) {
        Drops::find($id)->update(
            ['startFrom'=>$request['name'],
            'returnPath'=>$request['country_id']  
        ]);
        foreach($request['vmta'] as $ip_id){
            DB::insert('insert into ipdrops (ip_id,id_drop) values (?, ?)', [1, $id]);
        }
        $pageConfigs = ['bodyCustomClass' => 'app-page menu-collapse'];
        return redirect()->route('sends.index', ['pageConfigs' => $pageConfigs])
                        ->with('success','Typeliste updated successfully'); 
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sends  $sends
     * @return \Illuminate\Http\Response
     */
	  public function delete($id) {
        $sends = Sends::findOrFail($id);
        $sends->delete();
		$pageConfigs = ['bodyCustomClass' => 'app-page menu-collapse'];
        return redirect()->route('sends.index', ['pageConfigs' => $pageConfigs]);
    }
    public function redirectSuppfile($id,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11){      
        DB::update('update sends set supprition_file = ? where id_drops = ? and email_track_code = ? ', ['yes',$id , $id3]);
        $offre_id=$this->getOffreId($id);
        $unsubLink=$this->getUnsubLink($offre_id);
        return redirect()->away($unsubLink);
    }

    public function redirectfile($id,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9,$id10,$id11){     
        DB::update('update sends set open_offre = ? where id_drops = ? and email_track_code = ? ', ['yes',$id , $id3]);        
        $offre_id=$this->getOffreId($id);
        $offer_link=$this->getOfferLink($offre_id);
        return redirect()->away($offer_link);
    }
    public function openEmail($id,$id2,$id3,$id4,$id5,$id6,$id7,$id8,$id9){   
        $d=date('Y-m-d H:i:s');      
        Sends::updateOrCreate(
                ['id_drops' => $id, 'email_track_code' => $id3],
                ['email_open_datetime' => $d,
                'email_status' => 'yes']
        );		
    }
    public function sendTest(Request $request ){       
        $offre_id = $request['offre_id'];
        //echo $offre_id;
       // $country_id = $request['country_id'];
       // echo $country_id;
        $body_id = $request['body_id'];
        //echo $body_id ;
        $header_id = $request['header_id'];
        //echo $header_id;
        $fileId = $request['idCreative'];	
       // echo 	$fileId;	
        $returnPath = $request['returnpath'];
       // echo $returnPath;
        $emailTest = $request['emailTest'];
       // echo $emailTest;
        $sips=$request->get('ip_id');   
        
        /*$body= DB::table('bodys')
                ->select('bodys.texte')
                ->where('bodys.id',"=",$body_id)
                ->first(); 
        $unsubLink=$this->getUnsubLink($offre_id);
        $file=$this->getFile($fileId);
        $supImage=$this->getUnsubImage($offre_id);
        $offer_link=$this->getOfferLink($offre_id);       
        $ipf=$this->getipArray($sips);
        $email = explode(PHP_EOL, trim($emailTest));
        $ipServ=$_SERVER['HTTP_HOST'];       
        $ipsize=sizeof($ipf);
        $i=0;
        $idEmail=0;
        foreach($email as $to){
            if($i<$ipsize){
                $idEmail++; 
                $ipEnvoi=$ipf[$i];
                $idIP=$this->getIdIP($ipEnvoi);
                $domain=$this->getDomain($ipEnvoi);
                $from=$this->getFrom($offre_id);
                $subject=$this->getSubject($offre_id);                  
                $retPath=$this->changeReturnPath($returnPath,$domain);
                $tBody=$this->changeBody($body->texte,$offre_id,$idEmail,$fileId,$idIP,$ipServ,$file,$offer_link,$unsubLink,$supImage);
                //send 
                echo $tBody;
                $this->telnetSend($ipEnvoi,$domain,$subject,$to,$tBody,$retPath,$from);
            }
            $i++;
        }*/
    }

    public function pauseSend(){
       // $etat='pause';
        if($this->etat='send') $this->etat ='pause';
        else $this->etat ='send';
    }

    public function send(Request $request){	       
        $seed=$request->input('seed');
        $emailseed=$request->input('email');     
        $fraction=$request->input('fraction');               
        $x_delay=$request->input('x_delay');                             
        $drop_id=$request->input('id');  
        /*echo "Seed => ".$seed;
        echo '</br>';
        echo "Email test => ".$emailseed;
        echo '</br>';
        echo "Fraction => ".$fraction;
        echo '</br>';
        echo "x_delay => ".$x_delay;
        echo '</br>';
        echo "drop_id => ".$drop_id;*/
        //echo $ipf;
        // var_dump($ipf);

        echo '</br>';
      
        $data=$this->getData($drop_id);
        //var_dump($data);
        $offre_id=$this->getOffreId($drop_id);
        //echo $offre_id;
        $supFile=$this->getSuppFile($offre_id);
       // echo $supFile;
        $unsubLink=$this->getUnsubLink($offre_id);
        //echo $unsubLink;
        $header=$this->getHeader($drop_id);
        //echo $header;
        $body=$this->getBody($drop_id);
        //echo $body;
        $returnPath=$this->getReturnPath($drop_id);
        // echo $returnPath;
        $fileId=$this->getFileId($drop_id);
        //echo $fileId;
        $file=$this->getFile($fileId);
       // echo $file;
        $supImage=$this->getUnsubImage($offre_id);
       // echo $supImage; 
        $offer_link=$this->getOfferLink($offre_id);
        //echo $offer_link;
        $ip=$this->getIp($drop_id);
        //echo $ip;
        //var_dump($ip);
        $drop_count=$this->getCount($drop_id);
       // echo $drop_count;
        $idEmailPause=$this->getIdEmailPause($drop_id);
        if(!empty($idEmailPause)){

        }
       // echo $idEmailPause;
        $ipServ=$_SERVER['HTTP_HOST'];   
        //echo $ipServ; //$_SERVER['HTTP_HOST'];   
        $ipsize=sizeof($ip);
        $datasize=sizeof($data);
       // echo $datasize;
        $count=0;
        $rot=0;       
        $ipEnvoi=null;       
        $pause=0;
        for($i=0;$i<$datasize;$i++){
            $idEmail=$this->getIdEmail($data[$i]);
            if($idEmail==$idEmailPause) $pause=$i;
        }
        echo $pause;
        for($j=$pause;$j<=($pause+$fraction);$j++){
            $to=$data[$j];
            if($this->etat=='send'){
                //echo "lamiae";
                $pos = strpos($supFile, md5($to));
                if ($pos === FALSE) { 
                    //echo "lamiae";
                    $ipEnvoi= $ip[$rot];
                    $idEmail=$this->getIdEmail($to);
                    $idIP=$this->getIdIP($ipEnvoi);
                    $domain=$this->getDomain($ipEnvoi);
                    $from=$this->getFrom($offre_id);
                    $subject=$this->getSubject($offre_id);
                    $retPath=$this->changeReturnPath($returnPath,$domain);
                    $tBody=$this->changeBody($body,$drop_id,$idEmail,$fileId,$idIP,$ipServ,$file,$offer_link,$unsubLink,$supImage);
                    $this->telnetSend($ipEnvoi,$domain,$subject,$to,$tBody,$retPath,$from);
                    echo $tBody;
                    echo '</br>';
                    ///x_delay
                    sleep($x_delay);
                    echo '</br>';  
                    //rotation 
                    if($rot<$ipsize-1)  $rot++; 
                    else $rot=0;
                    $count++;
                    //seed
                    if($count%$seed==0)  $this->telnetSend($ipEnvoi,$domain,"Seed send state",$emailseed,$count." emails are sent",$retPath,"send"); 
                }
            }    
        }
            //count
            DB::update('update drops set count = ? , id_email = ? where id = ?', [$drop_count-$count , $idEmail , $drop_id]);      
    }

    public function getipArray($ipf){
        $sips=array();
        foreach($ipf as $id){
            $sip=Sips::findOrFail($id);
            $sips[]=$sip->IP;
        }
        return $sips;
    }
    public function getUnsubLink($id_offre){
        $offre = Offres::findOrFail($id_offre);
        return $offre->unsub;
    }  
    public function getUnsubImage($id_offre){ 
            $suppImage= DB::table('suppressions')
                        ->select('suppressions.*')
                        ->where('suppressions.offre_id',"=",$id_offre)
                        ->where('suppressions.extension',"<>",'txt')
                        ->first(); 
            $sup=null;//  $suppImage->path."/".$suppImage->name             
            return $suppImage->path."/".$suppImage->name;           
    } 
    public function getOfferLink($id_offre){
        $offre = Offres::findOrFail($id_offre);
        return $offre->olink;
    }
    public function getReturnPath($id_drop){
        $drop = Drops::findOrFail($id_drop);       
        return $drop->returnPath;
    }
    public function getIdEmail($to){
        $data=DB::table('datas')->select('id')
                ->where('email_Email',"=",$to)
                ->first();
       
        return $data->id;
    }
    public function getIdIP($ip){
        $ips=DB::table('sips')->select('id')
                ->where('IP',"=",$ip)
                ->first();
        return $ips->id;
    }
    public function getOffreId($id_drop){
        $drop = Drops::findOrFail($id_drop);
        return $offre_id=$drop->offre_id;
    }
    public function getFrom($offre_id){
        $offres=Offres::findOrFail($offre_id);
        $fName=$offres->froms;
        $tabName = explode(" ",$fName);
        $random_from_keys=array_rand($tabName);
        return trim($tabName[$random_from_keys]);
    }
    public function getSubject($offre_id){
        $offres=Offres::findOrFail($offre_id);
        $subject=$offres->subjects;
        $tabSubject=explode(" ",$subject);
        $random_subj_keys=array_rand($tabSubject);
        return trim($tabSubject[$random_subj_keys]);
    }
    public function getHeader($id_drop){
        $drop = Drops::findOrFail($id_drop);
        $header=Headers::findOrFail($drop->header_id);
        return $header->texte;
    }
    public function getBody($id_drop){
        $drop = Drops::findOrFail($id_drop);
        $body=Bodys::findOrFail($drop->body_id);
        return $body->texte; 
    }
    public function getRand(){
            $length=rand(10,100);
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";  
            $size = strlen( $chars );  
            $str="";
            for( $i = 0; $i < $length; $i++ ) {  
            $str.= $chars[ rand( 0, $size - 1 ) ];  
            }  
           return $str; 
    }
    public function getIp($id_drop){
        $ip  = DB::table('drops_has_sips')
                    ->select('drops_has_sips.sips_id')
                    ->where('drops_has_sips.drops_id',"=",$id_drop)
                    ->get();      
      
        $ip_ad=array();      
        foreach ($ip as $key => $value) {   
            $ips  = Sips::findOrFail($value->sips_id);
            if($ips->IP!== null && !empty($ips->IP)){
                $ip_ad[] =trim($ips->IP);              
            }       
        }   
        return $ip_ad;
    }
    public function getDomain($ip){
        $ip  = DB::table('sips')
            ->select('sips.*')
            ->where('sips.IP',"=",$ip)
            ->first();      
        $random=null;
        if($ip->random!==null && !empty($ip->random)){
            $random=$ip->random;
        }else{           
            $dom = Domains::findOrFail($ip->id_domain);
            $random = $dom->name;
        }
        return $random;
    }
    public function getData($id_drop){
        $liste_id =DB::table('drops_has_liste')->select('listesends_id')
        ->where('drops_has_liste.drops_id' , $id_drop)
            ->get();
        $arrQuery = array();
        foreach($liste_id as $key => $liste){
            if(!empty($liste->listesends_id) && $liste->listesends_id!== NULL){
                $data=DB::table('datas')->select('email_Email')
                ->where('id_List_Email',"=",$liste->listesends_id)
                ->get();
                foreach($data as $key1 => $email){
                    if(!empty($email->email_Email) && $email->email_Email!== NULL){
                       
                        $arrQuery[]=trim($email->email_Email);
                    }   
                }
            }
        }
        return $arrQuery;
    }
    public function getFile($file_id){
        $file = File::findOrFail($file_id);    
        return $file->path."/".$file->name;
    }
    public function getFileName($file_id){
        $file = File::findOrFail($file_id);    
        return $file->name;
    }
    public function getFileId($drop_id){
        $fid = Drops::findOrFail($drop_id); 
        return $fid->file_id;
    }
    public function getSuppFile($offre_id){
        $suppFile= DB::table('suppressions')
                    ->select('suppressions.*')
                    ->where('suppressions.offre_id',"=",$offre_id)
                    ->where('suppressions.extension',"=","txt")
                    ->first();
        $content=null;	
        if(!empty($suppFile->path) && $suppFile->path!==NULL){
            if (file_exists("../public/".$suppFile->path))
               {
                
                $content = file_get_contents("../public/".$suppFile->path."/".$suppFile->name);

               } 
            else echo "supp file n'existe pas ";
        }        
        return $content;
    }      
    public function changeReturnPath($returnPath,$domain){
        $returnPath =    preg_replace('#\[domain\]#',$domain,$returnPath);
        return $returnPath;
    }
    public function changeHead($head,$subject,$from,$to,$returnPath){
        $f = explode("@",$returnPath);       
        $date =    date('Y/m/d H:i:s');
        $head =    str_replace('/','',$head);//fromEmail: <[RandomC6]@site11.com>       
        $head =    preg_replace('#subject:--#',"subject:".$subject,$head);
        $head =    preg_replace('#fromName:--#',"fromName:".$from,$head);
        $head =    preg_replace('#\[date\]#',$date,$head);
        $head =    preg_replace('#\[to\]#',$to,$head);
        $head =    preg_replace('#\[domain\]#',$f[1],$head);
        $head =    str_replace('<[RandomC6]','< '.$f[0],$head);//RandomCD45
        $head =    preg_replace('#\[domain\]#',$f[1],$head);
        $head =    preg_replace('#\[RandomCD45\]#',rand(),$head);
        $head =    preg_replace('#"#'," ",$head);
        $split = explode(PHP_EOL,$head);
		$from = '';						   
		$fromName  = '';
		$fromEmail = '';							  
	    foreach($split as $line)
		{
			$params = explode(':',$line);						 
			if(strtolower($params[0]) == 'fromname')
			$fromName = $params[1];							  
			if(strtolower($params[0]) == 'fromemail')
			$fromEmail = $params[1];
		}			   
		$from=$fromName.$fromEmail;						   
		$headerTelNet = '';						   
		foreach($split as $line)
		{
			$params = explode(':',$line,2);							  
			if(strtolower($params[0]) == 'fromname')
				$headerTelNet.="from:$from\n";
			else{
					if(strtolower($params[0]) != 'fromemail'&& !empty($params[1]))
						$headerTelNet.=$params[0].':'.trim($params[1])."\n";
				}							  
		}						   
        return $headerTelNet;
    }            

    public function changeBody($body,$iddrop,$idEmail,$fileId,$idIP,$ip,$file,$offer_link,$Unsub,$supImage){
        $idFrom=rand();
        $idSubject=rand();  
        $body =     preg_replace('#\[domain\]#',$ip,$body);
		$body =     preg_replace('#\[idSend\]#',$iddrop."/",$body);
        $body =     preg_replace('#\[idEmail\]#',$idEmail."/",$body);
        $body =     preg_replace('#\[idFrom\]#',$idFrom."/",$body);
		$body =     preg_replace('#\[idSubject\]#',$idSubject."/",$body);
		$body =     preg_replace('#\[idCreative\]#',$fileId."/",$body);
		$body =     preg_replace('#\[idIP\]#',$idIP,$body);
        $body =     preg_replace('#\[nameCreative\]#',$file,$body); 
        $body =     preg_replace('#\[file\]#',$file,$body); 
        $body =     preg_replace('#\[RandomC/3\]#',$this->getRand()."/",$body); 
        $body =     preg_replace('#\[RandomC/2\]#',$this->getRand()."/",$body); 
        $body =     preg_replace('#\[offre\]#',$offer_link,$body); 
        $body =     preg_replace('#\[Unsub\]#',$Unsub,$body);
        $body =     preg_replace('#\[unsubfile\]#',$supImage,$body);           
        return $body;
    }
    public function getCount($drop_id){
        $count=Drops::findorfail($drop_id);
        return $count->count;
    }

    public function getIdEmailPause($drop_id){
        $id_email=Drops::findorfail($drop_id);
        return $id_email->id_email;
    }
    
    public function telnetSend($ip,$domain,$subject,$to,$header,$retPath,$from){ 	
	    app('App\Console\Commands\TelnetMAIL')->handle($ip,$domain,$subject,$to,$header,$retPath,$from);
    }
}
