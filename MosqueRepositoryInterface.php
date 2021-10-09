<?php
namespace App\Repositories;
use App\Mosque;

interface MosqueRepositoryInterface
{
 public function getMosques();

 public function getMosque($id);

 public function createMosque($mosque);

 public function updateMosque($mosque,$id);

 public function deleteMosque($id);

 public function convertfromhijritigeroian($hijri_date);

 public function getMosqueWaqfes($mosque_id);

 public function createMosqueWaqf($waqf);

 public function updateMosqueWaqf($waqf,$waqf_id);

 public function deleteMosqueWaqf($waqf_id);

 public function getMosqueWaqf($waqf_id);

 public function getMosqueAttachs($mosque_id);

 public function createMosqueAttach($attach);

 public function deleteMosqueAttach($attch_id);
 
 public function getAttach($attch_id);

 public function deletePermission();

 public function createPermission();

 public function updatePermission();

 public function printPermission();

 public function filterMosques($criteria,$inputval);
 
 public function MosquesWithiMaamMoazenSkn();

 public function MosquesHasWaqfes();

 public function MosquesHasWaqfesByName($mosque_type,$mosque_name);
 
}
