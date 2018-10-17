<script>
	$(document).ready(function() {
        $("#addNew").on('click',function() {
            $("#countryName").val('');
            $("#shortDesc").val('');
            $("#longDesc").val('');
            $("#actionButton").val('Insert').attr('class','btn btn-primary').attr('style','display: show').attr('onclick',"manageData('insertRow')");
            $("#modal-edit").attr('style','display: show');
            $("#modal-view").attr('style','display: none');   
            $("#modalTitle").text("Insert data");     
        });

		generateData(0,50);
	});

    // for generating table with data
	function generateData(start, limit)
	{
		$.ajax({

			url: '../src/ajax.php',
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

	// fatching data from database in json format.
	// and put data in modal (view, or edit)
	function readOrEdit(rowID, readModal=0)
	{
		var countryName = $("#countryName");
		var shortDesc = $("#shortDesc");
		var longDesc = $("#longDesc");

		$.ajax({

			url: '../src/ajax.php',
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
    // for deleting row
    function deleteRow(rowID)
    {
            if(confirm("Are you sure?")) {
                $.ajax({

                    url: '../src/ajax.php',
                    method: 'POST',
                    dataType: 'text',
                    data: {
                        key: 'deleteRow',
                        rowID: rowID
                    },
                    success: function(response)
                        {
                        	if(response == "success") {
                           		$("#country_"+rowID).parent().remove();
                        	} else {
                        		alert(response);
                        	}
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

				url: '../src/ajax.php',
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