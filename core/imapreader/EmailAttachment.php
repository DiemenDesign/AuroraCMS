<?php class EmailAttachment{public$id;public$name;public$file_path;public$type;public$mime;public function setID($id){$this->id=$id;return$this;}public function setName($name){$this->name=$name;return$this;}public function setType($type){$this->type=$type;return$this;}public function setMime($mime_type){$this->mime=$mime_type;return$this;}public function setFilePath($file_path){$this->file_path=$file_path;return$this;}public function setAttachmentData($data){$this->attachment_data=$data;return$this;}public function id(){return$this->id;}public function name(){return$this->name;}public function filePath(){return$this->file_path;}public function content(){return$this->attachment_data;}public function type(){return$this->type;}public function isInline(){return$this->type()=='inline'?true:false;}}
