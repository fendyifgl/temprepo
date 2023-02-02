<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?=base_url()?>asset/css/news.css" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>asset/css/pricing-table.css" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>asset/plugin/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
<link href="<?=base_url()?>asset/css/portfolio.css" rel="stylesheet" type="text/css"/>
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
<style>
.alert {
  padding: 20px;
  background-color: #f44336;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
</style>
<div class="container">
    <!-- BEGIN PAGE BREADCRUMB -->
    <ul class="page-breadcrumb breadcrumb">
        <li>
            <?=$this->template->title?>
        </li>
    </ul>
    <!-- END PAGE BREADCRUMB -->

    <!-- BEGIN PAGE CONTENT INNER -->
    <div class="row margin-top-10">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE TABLE PORTLET-->
            <div class="portlet light">
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12 news-page">
							<div class="row">
                                <div class="portlet light">
								<?php if($this->session->flashdata('status') != null || $this->session->flashdata('status') != '') {;?>
									<div class="alert"  data-flashdata='<?= $this->session->flashdata('status');?>'>
									  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
									  <strong><?php echo $this->session->flashdata('status');?>!</strong> <?php echo $this->session->flashdata('pesan');?>
									</div>  
								<?php } ?>
									<div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-file-text-o font-green-sharp"></i>
                                            <span class="caption-subject font-green-sharp bold uppercase">List Dokumen</span>
                                        </div>
										<div class="col card-header text-right">
                                            <button type="button" class="btn btn-success mt-3 btn-sm " data-toggle="modal" data-target="#exampleModal">Tambah Data</a>
                                        </div>
                                    </div>
									<div class="portlet-body">
                                       <table id="tabel-data" class="display" style="width:100%">
											<thead>
												<tr>
													<th>No</th>
													<th>Judul - Deskripsi</th>
													<th>Link Dokumen</th>
													<th>Kategori</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											 <?php 
											 	$no = 1; 
											 	$kategori = '';
												foreach ($data as $dataimg => $data) { 
												if($data['KATEGORI'] == '1'){
													$kategori = 'Agen';
												}elseif($data['KATEGORI'] == '2'){
													$kategori = 'Agen LPA';
												}elseif($data['KATEGORI'] == '3'){
													$kategori = 'Bancassurance ';
												}elseif($data['KATEGORI'] == '4'){
													$kategori = 'Worksite Specialist';
												}elseif($data['KATEGORI'] == '0'){
													$kategori = 'ALL';
												}
											?>
											<tr>
												<td><?= $no++; ?></td>
												<td><?= $data['NAMAEBOOK'].' - '.$data['KETERANGAN'];?></td>
												<td><a target="_blank" href="<?php echo base_url('asset/learning/ebook').'/'.$data['EBOOK'];?>"><?= $data['NAMAEBOOK'];?></a></td>
												<td><?= $kategori ?></td>
												<td><?= $data['STATUS'];?></td>
												<td>
													<a href="#" class="btn btn-success mt-3 btn-sm" id="buttonSend" onclick="edit('<?= $data['KDEBOOK'];?>')">Edit</a>
													<button class="btn btn-danger mt-3 btn-sm" onclick="deleted(<?=$no;?>)"  id='deleted_<?=$no;?>'>Delete</button>
													<input type='hidden' id='id_<?=$no;?>' value='<?=$data['KDEBOOK'];?>'/>
													<!--<a class="btn btn-danger mt-3 btn-sm" href='<?= base_url('pengaturan/deleteDokumen').'/'.$data['KDEBOOK'];?>' >Delete</a>-->
												</td>
											</tr>
											<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('pengaturan/postDokumen');?>" method="post" enctype="multipart/form-data">
      <div class="modal-body">
        <div class="form-group">
			<label class="control-label">Nama Document</label>
			<div>
				<input type="text" class="form-control input-lg" name="namabook" required>
			</div>
        </div>
		<div class="form-group">
			<label class="control-label">Deskripsi</label>
			<div>
				<input type="text" class="form-control input-lg" name="deskripsi">
			</div>
        </div>
        <div class="form-group">
			<label class="control-label">Kategori</label>
			<div>
				<select class="form-control input-lg" name="kategori" required>
					<option value="" selected>-- Jenis Kategori --</option>
					<option value="1">Agency </option>
					<option value="3">Bancassurance</option>
					<option value="4">Worksite Specialist</option>
					<option value="0">ALL</option>
				</select>
			</div>
        </div>
		<div class="form-group">
			<label class="control-label">File Doc</label>
			<span style="color:red">*Maksimal 10 MB & Format File PDF Only</span>
			<div>
				<input type="File" class="form-control input-lg" accept=".pdf, .docx, .doc" id="doc" name="doc" required>
			</div>
        </div>
		<div class="form-group">
			<label class="control-label">Nomor Urut</label>
			<div>
				<input type="text" class="form-control input-lg" name="nourut" >
			</div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
	  </form>
    </div>
  </div>
</div>
</div>

<div id="edit"></div>

<script type="text/javascript" src="<?=base_url()?>asset/plugin/jquery-mixitup/jquery.mixitup.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>asset/plugin/fancybox/source/jquery.fancybox.pack.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.js"></script>



<script>
$(document).ready(function(){
        $('#tabel-data').DataTable();
    });
	
function deleted(no){
	let id = document.getElementById('id_'+no).value;
	//swall
	Swal.fire({
		  title: 'Apakah Kamu Yakin?',
		  text: "Ingin Menghapus Data",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes'
		}).then((result) => {
		  if (result.isConfirmed) {
			Swal.fire(
			  'Success',
			  'Penghapusan Data Berhasil',
			  'success'
			)
			setTimeout(function () {
                window.location.href = "deleteDokumen/" + id;
            }, 1000);  
		  }
		})
	}

function edit(id){
	var id = id;
	$.ajax({
        url: "getDataDokumen",
        type : "POST",
        dataType: "JSON",   
        data: {id:id},
        success: function(data){
			var namabook = '';
			var keterangan = '';
			var urutan = '';
			var status = '';
			let kategori = '';
			
			console.log(data[0].STATUS);
			
			if(data[0].STATUS == null){
				status = '';
			} else {
				status = data[0].STATUS;
			}
			
			if(data[0].NAMAEBOOK == null) {
				namabook = '';
			} else {
				namabook = data[0].NAMAEBOOK;
			}
			
			if(data[0].KETERANGAN == null) {
				keterangan = '';
			} else {
				keterangan = data[0].KETERANGAN;
			}
			
			if(data[0].URUTAN == null) {
				urutan = '';
			} else {
				urutan = data[0].URUTAN;
			}

			if(data[0].KATEGORI == null){
				kategori = '';
			} else {
				kategori = data[0].KATEGORI;
			}
			
			
			$('#edit').html(`<div class="modal fade" id="editform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Update Data</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
								  </div>
								  <form action="<?= base_url('pengaturan/saveDokumen');?>" method="post" enctype="multipart/form-data">
								  <div class="modal-body">
									<div class="form-group">
										<label class="control-label">Nama Document</label>
										<div>
											<input type="text" class="form-control input-lg" readonly name="namabook" value="${namabook}">
											<input type="hidden"  name="iddoc" value="${data[0].KDEBOOK}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label">Deskripsi</label>
										<div>
											<input type="text" class="form-control input-lg" name="deskripsi" value="${keterangan}">
										</div>
									</div>
									<div class="form-group">
										<label class="control-label">Kategori</label>
										<div>
											<select class="form-control input-lg" name="kategori" required>
												<option ${kategori == '' ? 'selected' : ''}>-- Jenis Kategori --</option>
												<option value="1" ${kategori == '1' ? 'selected' : ''}>Agen</option>
												<option value="3" ${kategori == '3' ? 'selected' : ''}>Bancassurance</option>
												<option value="4" ${kategori == '4' ? 'selected' : ''}>Worksite Specialist</option>
												<option value="0" ${kategori == '0' ? 'selected' : ''}>ALL</option>
											</select>
										</div>
							        </div>
									<div class="form-group">
										<label class="control-label">File Doc</label>
											<span style="color:red">*Kosongkan Jika Tidak Mengubah & Maksimal 10 MB, PDF Only!!!</span>
										<div>
											<input type="File" class="form-control input-lg" id="doc" name="doc" >
											<input type="hidden" name="docold" value="${data[0].EBOOK}>
										</div>
									</div>
									<div class="form-group">
										<label class="control-label">Nomor Urut</label>
										<div>
											<input type="text" class="form-control input-lg" name="nourut" value="${urutan}">
										</div>
									</div>
									<div class="form-group">
											<label class="control-label">Status</label>
											<div>
												<select class="form-control" name="status">
													<option value="1" ${status == '1' ? 'selected' : ''}> Aktif</option>
													<option value="0" ${status == '0' ? 'selected' : ''}> Non Aktif</option>
												</select>
											</div>
									</div>

								  <div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary">Save changes</button>
								  </div>
								  </form>
								</div>
							  </div>
							</div>
						</div>`);
			$('#editform').modal('show');
		}
    });
 }
</script>