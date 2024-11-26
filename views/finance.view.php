
<?php
		require 'partials/security.php';
    require 'partials/header.php';
    require 'model/Database.php';
?>

<script>
	function toggleDiv() {
    	var paidDiv = document.getElementById("paid_div");
    	var notPaidDiv = document.getElementById("not_paid_div");
    	paidDiv.style.display = "none";
    	notPaidDiv.style.display = "block";
	}
</script>


    <!-- Page Wrapper -->
<div id="wrapper">
  <!-- Sidebar -->
  <?php require 'partials/sidebar.php' ?>

    <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">
		<!-- Main Content -->
		<div id="content">

			<!-- Topbar -->
			<?php
					require 'partials/nav.php';
			?>

			<!-- Begin Page Content -->
			<div class="container-fluid">

					<!-- Content Row -->
					<form id="collectBy">          

            <div class="form-row">
              <div class="form-group col-md-6">
                <label><strong>Amount:</strong></label>
                <input type="number" name="amount" id="" class="form-control" placeholder="e.g 20,000.00">
                <small id="errorAmount" class="text-danger"></small>
              </div>
              <div class="form-group col-md-6">
                <label><strong>Collect by:</strong></label>
                <input name="collectby" placeholder="e.g Mr. Musa" type="text" class="form-control" />
                <small class="text-danger" id="errorCollect"></small>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label><strong>Reason:</strong></label>
                  <textarea placeholder="e.g Generator Maintenance" name="reason" id="" class="form-control"></textarea>
                <small id="errorReason" class="text-danger"></small>
              </div>
            </div>
            <button type="submit" class="btn btn-primary mb-3">Save</button>
          </form>
			</div>
		</div>
		<!-- End of Main Content -->

<?php
  require 'partials/footer.php';
?>

<script>
  $(document).ready(function(){
    $('#collectBy').on('submit', function(e){
      e.preventDefault();
      
      $.ajax({
        url: 'model/finance.user.php',
        dataType: 'JSON',
        data: $(this).serialize(),
        type: 'POST',
        success: function(response){
          if(!response.errors){
            const Toast = Swal.mixin({
							toast: true,
							position: "top-end",
							showConfirmButton: false,
							timer: 2000,
							timerProgressBar: true,
							didOpen: (toast) => {
								toast.onmouseenter = Swal.stopTimer;
								toast.onmouseleave = Swal.resumeTimer;
							}
						});
						Toast.fire({
							icon: "success",
							title: response.success.success
						});
          }else{
            $('#errorAmount').text(response.errors.amount || '');
            $('#errorCollect').text(response.errors.collectby || '');
            $('#errorReason').text(response.errors.reason || '');
          }
          $('#collectBy')[0].reset();
        },
        error: function(error){
          alert('error:' + error)
        }
      });
    });
  });
</script>
