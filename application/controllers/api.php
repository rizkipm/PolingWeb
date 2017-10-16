<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {
	function __construct(){
		parent::__construct();

		date_default_timezone_set('Asia/Jakarta');
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		
	}

	// private function check_sesi(){
	// 	$token = $this->input->post('f_token');
	// 	$device = $this->input->post('f_device');

	// 	//$token = 'a6bccee9979eef5c66532b5a36880d39';
	// 	//$device = 'ffffffff-be46-4574-ffff-ffffbdceeae1';
		
	// 	if($token || $device){
	// 		$sql = "SELECT * FROM sesi WHERE 
	// 			sesi_key = ? AND sesi_device = ? 
	// 			AND sesi_status = ?";
	// 		// $this->db->where('sesi_key', $token);
	// 		// $this->db->where('sesi_status', 1);
	// 		// $this->db->where('sesi_device', $device);
	// 		$query = $this->db->query($sql, array($token, $device, 1));
	// 		if($query->num_rows() > 0){
	// 			return true;
	// 		}else{
	// 			return false;
	// 		}
	// 	}else{
	// 		return false;
	// 	}

		
		
	// }

	// public function login(){ 
	// 	$data = array();
	// 	$device = $this->input->post('device');
	// 	$email =  $this->input->post("t_email");
	// 	$password =  $this->input->post("t_password");
	// 	$device_type = $this->input->post("device_type");

	// 	if($email == '' || $password == ''){
	// 		$data['result'] = 'false';
	// 		$data['msg'] = 'Silahkan isi email dan  password anda.';
	// 		echo json_encode($data);
	// 		return;
			
	// 	}
		
	// 	$this->db->where('email', $email);
	// 	$this->db->where('password', md5($password));
		
	// 	$query = $this->db->get('tb_user');
	// 	if($query->num_rows() > 0){
	// 		$q = $query->row();

	// 		//delete semua sesi user ini sebelumnya
	// 		$this->db->where('id_user' , $q->id_user);
	// 		$this->db->update('tb_sesi', array('sesi_status' => 9));					
	// 		//create token
	// 		$key = md5(date('Y-m-d H:i:s').$device);
	// 		//masukkan kedlam tabel sesi
	// 		$simpan = array();
	// 		$simpan['sesi_key'] =  $key;
	// 		$simpan['id_user'] = $q->id_user;
	// 		$simpan['sesi_device'] = $device;
	// 		$status = $this->db->insert('tb_sesi', $simpan);
	// 		if($status){
	// 			$data['result'] = 'true';
	// 			$data['token'] =  $key;
	// 			$data['data'] = $q;
	// 			$data['msg'] = 'Login berhasil.';
	// 			$data['idUser'] = $q->id_user;

	// 			if(!empty($device_type)){
	// 				if($device_type == "ios"){
	// 					$token = $this->input->post("token");
	// 					$data['player_id'] = $this->register_player_id($token, $q->id_user);
	// 				}
	// 			}
	// 		}else{
	// 			$data['result'] = 'false';
	// 			$data['token'] = '';
	// 			$data['idUser'] = '';
	// 			$data['msg'] = 'Error create sesi login, Silahkan coba lagi.';
	// 		}
	// 	}else{			
	// 		$data['result'] = 'false';
	// 		$data['msg'] = 'Username atau password salah.';
			
	// 	}		
	// 	echo json_encode($data);
	// }


	

	// public function daftar(){ 
	// 	$data = array();
	// 	$usernama = $this->input->post('usernama');
	// 	$email = $this->input->post('email');
	// 	$password = $this->input->post('password');
	// 	$hp = $this->input->post('phone');
	// 	$alamat = $this->input->post('alamat');
		
	// 	//check email in di database
	// 	$this->db->where('email', $email);
		
	// 	$q = $this->db->get('tb_user');

	// 	if($q->num_rows() > 0) {
	// 		$data['result'] = 'false';
	// 		$data['msg'] = 'Email anda sudah terdaftar, silahkan untuk login.';
	// 	}else{		
	// 		$simpan = array();
			
	// 		$simpan['password'] = md5($password);
	// 		$simpan['usernama'] = $usernama;
	// 		$simpan['email'] = $email;
	// 		$simpan['alamat'] = $alamat;
			
	// 		$simpan['no_hp'] = $hp;
			

	// 		$status = $this->db->insert('tb_user',$simpan);
			
	// 		if($status){				
	// 			$data['result'] = 'true';
	// 			$idUser = $this->db->insert_id();		
				
	// 			$data['msg'] = 'Pendaftaran berhasil';
				


				
	// 		}else{
	// 			$data['result'] = 'false';
	// 			$data['msg'] = 'Pendafatran gagal, silahkan coba kembali';
	// 		}

	// 	}
		
	// 	#pre($this->db->last_query());
	// 	echo json_encode($data);
	// }

	public function get_galeri(){ 
		$data = array();
	
		$sql = "SELECT * FROM tb_dokumentasi ORDER BY id_dok DESC";
        
		$q = $this->db->query($sql);
		if($q->num_rows() > 0){				
			$data['result'] = 'true';
			$data['msg'] = 'Data semua Galeri';
			$data['data'] = $q->result();
		}else{
			$data['result'] = 'false';
			$data['msg'] = 'Tidak ada data Galeri';
		}
		
		//#pre($this->db->last_query());
		echo json_encode($data);
	}

	public function upload_gambar(){ 
		$data = array();


		
		$nama_dok	= $this->input->post('nama_dok');
		$point_dok = 10;
		
		$foto_dok = $this->input->post('foto_dok');

		$namafile = "";
		if(!empty($_FILES['userfile'])){
			$hasil = $this->upload_transfer('data');

			if($hasil['result'] == 'false'){
				$data['result'] = 'false';
				$data['msg'] = $hasil['msg'];

				echo json_encode($data);
				return;
			}else{
				$namafile = $hasil['namafile'];
				
			}
		}

		

		$simpan['nama_dok'] = $nama_dok;
		$simpan['foto_dok'] = $namafile;
	
		$simpan['point_dok'] = $point_dok;
		
		
		$status = $this->db->insert('tb_dokumentasi',$simpan);

		

		
		if($status ){	
			$data['result'] = 'true';
			$data['namafile'] = $namafile;
			$data['msg'] = 'Upload Foto  Berhasil';

		}else{
			$data['result'] = 'false';
			$data['msg'] = 'Upload Foto Gagal';
		}
		
		#pre($this->db->last_query());
		echo json_encode($data);
	}

	public function upload_transfer($folder = 'data', $size = 3000000)
	{
		$data = array();
	    $folder = 'img/'.$folder.'/';

	   	$filename = $_FILES["userfile"]["name"];
		$file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
		$file_ext = substr($filename, strripos($filename, '.')); // get file name
		$filesize = $_FILES["userfile"]["size"];
		$allowed_file_types = array('.jpg','.png');	

		if (in_array($file_ext,$allowed_file_types) && ($filesize < $size))
		{	
			// Rename file
			buatDir($folder);
			$newfilename = md5($file_basename.date('YmdHis')) . $file_ext;
			if (file_exists($folder . $newfilename))
			{
				// file already exists error
				$data['result'] = "false";
				$data['msg'] = "File / nama file sudah ada diserver";
			} else	{		
				if(move_uploaded_file($_FILES["userfile"]["tmp_name"], $folder . $newfilename)){
					$data['result'] = "true";
					$data['namafile'] = $newfilename;
					$data['msg'] = "Upload file berhasil.";
				}else{
					$data['result'] = "false";
					$data['msg'] = "Upload File Gagal, Silahkan coba lagi";
				}
				
			}
		}elseif (empty($file_basename)){	
			$data['result'] = "false";
			$data['msg'] = "Silahkan Pilih File untuk diupload, Silahkan coba lagi";
		}elseif ($filesize > $size){	
			$data['result'] = "false";
			$data['msg'] = "Ukuran file Terlalu besar max 1MB, Silahkan coba lagi";
		}else{
			// file type error
			unlink($_FILES["file"]["tmp_name"]);

			$data['result'] = "false";
			$data['msg'] = "File yang diupload harus berektensi ".implode(', ',$allowed_file_types);
		}

		return $data;
	}

	public function update_love_dok(){ 
		$data = array();

		$id_dok = $this->input->post('id_dok');
		$point_dok = $this->input->post('point_dok');
		$simpan['point_dok'] = $point_dok;
		
		$this->db->where('id_dok', $id_dok);

		$hasil = $this->db->update('tb_dokumentasi', $simpan);
		if($hasil){
			$data['result'] = 'true';
			
			$data['msg'] = 'Point anda berhasil ditambahkan';
		}else{
			$data['result'] = 'false';
			$data['msg'] = 'Gagal nambah point';
		}		
			

			
		
		
		#pre($this->db->last_query());
		echo json_encode($data); 
	}

	// public function get_menuByID(){ 
	// 	$data = array();

	// 	$id_menu = $this->input->post('id_menu');
	
	// 	$sql = "SELECT * FROM tb_info WHERE id_menu = '$id_menu' ORDER by id_info DESC";
        
	// 	$q = $this->db->query($sql);
	// 	if($q->num_rows() > 0){				
	// 		$data['result'] = 'true';
	// 		$data['msg'] = 'Data semua menu';
	// 		$data['data'] = $q->result();
	// 	}else{
	// 		$data['result'] = 'false';
	// 		$data['msg'] = 'Tidak ada data menu';
	// 	}
		
	// 	//#pre($this->db->last_query());
	// 	echo json_encode($data);
	// }

	// public function get_infoByID(){ 
	// 	$data = array();

	// 	$id_info = $this->input->post('id_info');
	
	// 	$sql = "SELECT * FROM tb_info WHERE id_info = '$id_info' ORDER by id_info DESC";
        
	// 	$q = $this->db->query($sql);
	// 	if($q->num_rows() > 0){				
	// 		$data['result'] = 'true';
	// 		$data['msg'] = 'Data detail info';
	// 		$data['data'] = $q->result();
	// 	}else{
	// 		$data['result'] = 'false';
	// 		$data['msg'] = 'Tidak ada data info';
	// 	}
		
	// 	//#pre($this->db->last_query());
	// 	echo json_encode($data);
	// }



	// public function get_Slider(){ 
	// 	$data = array();
	
	// 	$sql = "SELECT * FROM tb_info ORDER BY id_info DESC";
        
	// 	$q = $this->db->query($sql);
	// 	if($q->num_rows() > 0){				
	// 		$data['result'] = 'true';
	// 		$data['msg'] = 'Data semua Slider';
	// 		$data['data'] = $q->result();
	// 	}else{
	// 		$data['result'] = 'false';
	// 		$data['msg'] = 'Tidak ada data Slider';
	// 	}
		
	// 	//#pre($this->db->last_query());
	// 	echo json_encode($data);
	// }

	


	
	



	
}
	


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */