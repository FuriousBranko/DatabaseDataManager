<!DOCTYPE html>
<html>
<head>
	<title>Data Manager</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
</head>

<body>
    
<div class="container" style="margin-top: 30px;">

<!-- Modal for edit/add -->
<div class="modal fade" id="modalReadEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">

      		<div class="modal-header">
	        	<h3 class="modal-title" id="modalTitle"></h3>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	       		</button>
      		</div>

      		<div class="modal-body" id="modal-edit">
		        <input type="text" class="form-control" id="countryName" placeholder="Country name: "><br>
		        <textarea class="form-control" id="shortDesc" placeholder="Short description: "></textarea><br>
		        <textarea class="form-control" id="longDesc" placeholder="Long description: "></textarea>
		        <input type="hidden" id="currentRowID" value="0">
      		</div>

            <div class="modal-body" id="modal-view" style="display: none">
                <h5> Short text </h5>
                <div id="shortDescView"></div>
                <br><br>
                <h5> Long text </h5>
                <div id="longDescView"></div>
            </div>

	      	<div class="modal-footer">
	        	<input type="button" class="btn btn-secondary" data-dismiss="modal" value="Close">
	        	<input type="button" class="btn btn-primary" value="Insert" id="actionButton" onclick="manageData('insertRow');">
      		</div>

    	</div>
 	</div>
</div>

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h2>MySQL Data Manager</h2>
			<br><br>
			<input style="float:right;" type="button" class="btn btn-success" data-toggle="modal" data-target="#modalReadEdit" id="addNew" value="Add new">
				<table class="table table-hover table-bordered">
					<thead class="thead-dark">
						<tr>
							<th>ID</th>
							<th>Country Name</th>
							<th>Options</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
		</div>
	</div>

</div>

</body>

<script
  src="http://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>

<script type="text/javascript">
	
	$(document).ready(function() {
        $("#addNew").on('click',function() {
            $("#countryName").val('');
            $("#shortDesc").val('');
            $("#longDesc").val('');
            $("#actionButton").val('Insert').attr('class','btn btn-primary').attr('style','display: show');
            $("#modal-edit").attr('style','display: show');
            $("#modal-view").attr('style','display: none');   
            $("#modalTitle").text("Insert data");     
        });

		generateData(0,10);
	});

	function generateData(start, limit)
	{
		$.ajax({

			url: 'ajax.php',
			method: 'POST',
			dataType: 'text',
			data: {
				key: 'getExistingData',
				start: start,
				limit: limit
			},
			success: function(response)
			{
				if(response != 'reachedMax') {
					$('tbody').append(response);
					start+=limit;
					generateData(start, limit);
				} else {
					$('.table').DataTable();
				}
			}
		});
	}

    // this is function for reading data via ID,
    // fatching data with json
    // if type - 0, then is edit mode
	function readOrEdit(rowID, readModal=0)
	{
		var countryName = $("#countryName");
		var shortDesc = $("#shortDesc");
		var longDesc = $("#longDesc");

		$.ajax({

			url: 'ajax.php',
			method: 'POST',
			dataType: 'json',
			data: {
				key: 'readRow',
				rowID: rowID
			},
			success: function(response)
			{
                if(readModal == 0){
                    $("#modal-edit").attr('style','display: show');
                    $("#modal-view").attr('style','display: none');
                    $("#modalTitle").text("Edit data")
                    $("#actionButton").val("Edit").attr('onclick','manageData("editRow")').attr('style','display: show');
                    $("#currentRowID").val(response.rowID);
                    $("#countryName").val(response.countryName);
                    $("#shortDesc").val(response.shortDesc);
                    $("#longDesc").val(response.longDesc);
                } else {
                    $("#modal-edit").attr('style','display: none');
                    $("#modal-view").attr('style','display: show');
                    $("#modalTitle").text(response.countryName)
                    $("#actionButton").attr('style','display: none');
                    $("#currentRowID").val(response.rowID);
                    $("#shortDescView").html(response.shortDesc);
                    $("#longDescView").html(response.longDesc);                
                }
			}
		});		
	}

    function deleteRow(rowID)
    {
            if(confirm("Are you sure?")) {
                $.ajax({

                    url: 'ajax.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        key: 'deleteRow',
                        rowID: rowID
                    },
                    success: function(response)
                        {
                            $("#country_"+rowID).parent().remove();
                        }
                });
            }
    }

    // this is for button where we submit/edit fields
	function manageData(key)
	{
		var countryName = $("#countryName");
		var shortDesc = $("#shortDesc");
		var longDesc = $("#longDesc");
		var rowID = $("#currentRowID");
		
		if(isNotEmpty(countryName) && isNotEmpty(shortDesc) && isNotEmpty(longDesc)) {
			
			$.ajax({

				url: 'ajax.php',
				method: 'POST',
				dataType: 'text',
				data: {
					key: key,
					countryName: countryName.val(),
					shortDesc: shortDesc.val(),
					longDesc: longDesc.val(),
					rowID: rowID.val()
				},
				success: function(response)
				{
					if(response == 'success') {
						$("#modalReadEdit").modal('hide');
                        $("#country_"+rowID.val()).text(countryName.val());
						countryName.val('').css('border', '');
						shortDesc.val('').css('border', '');
						longDesc.val('').css('border', '');
					} else {
						countryName.css('border', 'solid red 1px');
						alert(response);
					}
					
				}

			});

		}
	}

	function isNotEmpty(caller)
	{
		var result;
		if(caller.val() == "") {
			caller.css('border','solid red 1px');
			result = false;
		} else {
			caller.css('border', 'solid green 1px');
			result = true;
		}

		return result;
	}

</script>
</html>