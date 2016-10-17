<?php
namespace Accountsync\Model;
use Kruul\Pdodb;

class AccountsyncMapper{
    private $AdapterOSS;
    private $AdapterCabinet;

    function __construct($adapterOSS=null,$adapterCabinet=null){
	  	$this->AdapterOSS=$adapterOSS;
	  	$this->AdapterCabinet=$adapterCabinet;
    }

    function getNewClient($datebeg=null,$dateend=null){
    	// по умолчанию $datebeg=SYSDATE-1 ; $dateend=SYSDATE
       $db=$this->AdapterCabinet;
       $res=$db->query('select * from language');

       print_r($res->fetch());

    	$sql=<<<SQL
select pa.name,pa.id
  from personalaccount pa,
       personalaccounttype pat,
       clients cls
 where pat.id = pa.PERSONALACCOUNTTYPE_ID and
       pa.client_id = cls.id and
       pa.PERSONALACCOUNTTYPE_ID in (1,2,3,4,10,11) and
       pa.id in ( select distinct r.PERSONALACCOUNT_ID
  from requestforservice r, fileinclient f
 where trunc(r.CREATEDATE)>= (To_Date(to_char(SYSDATE-1,'DD.MM.YYYY'))) and trunc(r.CREATEDATE) < To_Date(to_char(SYSDATE,'DD.MM.YYYY'))
   and f.SUBJ_ID=r.PERSONALACCOUNT_ID
   and r.CREATEDATE = (select min(r3.CREATEDATE) from requestforservice r3 where r.PERSONALACCOUNT_ID=r3.PERSONALACCOUNT_ID))
 order by cls.id

SQL;

    }


}