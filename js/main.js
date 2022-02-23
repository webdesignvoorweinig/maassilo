	$(document).ready(function(){
   		var postcount;
    	$(document).on("click", ".sbmt", function(){
        	postcount = $(this).attr("name");
        	// alert(postcount);
        });
    		
    
        	$(document).on("submit","#cevent", function(event) {
            	var request;
                event.preventDefault();
        		var values = $(this).serialize();
        		
        		request = $.ajax({
           		 	url: "process.php?a=cevent",
            		type: "post",
            		data: values,
                	cache: false,
                	async: true
        		});
            	
        		request.done(function (response, textStatus, jqXHR){
         		
					alert("Event succesvol aangemaakt");
					// show succes message
         			//$("#result").html('event succesvol aangemaakt');
                
            	$("#gevents").load(location.href+" #gevents>*","");
                $("#cevent").load(location.href+" #cevent>*","");
                
                });
        		
        		request.fail(function (){

        		// Show error
        		$("#result").html('There is error while submit');
    			});
				
             });
        
        	$(document).on("submit", "#gevents", function(event){
 
            	var getrequest;
            	event.preventDefault();

            	var gvalues = $(this).serialize();
             	// op basis van de naam van de submit button de juiste actie uitvoeren.
            	if(postcount === "getevent") {
            		getrequest = $.ajax({
                		url: "process.php?a=gevent",
                		type: "post",
                		data: gvalues,
                		cache: false
                	});
               
                } else {
                	getrequest = $.ajax({
                    	url: "process.php?a=pevent",
                    	type: "post",
                    	data: gvalues,
                    	cache: false
                    
                    });
                
                
                }
            	getrequest.done(function (response, textStatus, jqXHR){
                	$("#stock").html(response);
                	
                });
            
            	getrequest.fail(function (){

        		// Show error
        		$("#stock").html('There is error while submit');
    			});
            });
        
        	$(document).on("submit", "#prestock", function(event){
            	event.preventDefault();
				if(!$("#bars").val()){
					alert("Je vergeet een bar te selecteren");
				} else {
				var postrequest;
            	
            	var pvalues = $(this).serialize();
            	
            	postrequest = $.ajax({
                	url: "process.php?a=prestock",
                	type: "post",
                	data: pvalues,
                	cache: false
                });
            
            	postrequest.done(function (response, textStatus, jqXHR){
                	$("#tmp").html(response);
                	$("#prestock").hide();
                });
            
            	postrequest.fail(function(){
                	$("#tmp").html("there is something wrong");	
                });
            	};
            });
        
			$(document).on("submit", "#pcount", function(event){
				var updatestock;
				event.preventDefault();
				var uvalues = $(this).serialize();

				updatestock = $.ajax({
					url: "process.php?a=ustock",
					type: "post",
					data: uvalues,
					cache: false
				});

				updatestock.done(function (response, textStatus, jqXHR){
					//alert("De eindtelling is succesvol opgeslagen");
					alert(response);
					//$("#pcount").hide();
				
				});

				updatestock.fail(function(){
					$("#tmp").html("Er is iets niet goed");
				});

			});

			$(document).on("submit", "#geventsdata", function(event){
				var getcsv;
				var csvdata = $(this).serialize();
				event.preventDefault();

				getcsv = $.ajax({
					url: "process.php?a=getcsv",
					type: "post",
					data: csvdata,
					cache: false
				});

				getcsv.done(function(response, textStatus, jqXHR){
					$("#datacheck").html(response);
					
				});

				getcsv.fail(function(){
					$("#datacheck").html("Wij hebben voor dit evenement nog geen voorraadlijsten klaar staan");
				});

			});

			$(document).on("submit", "#sendcsv", function(event){
				var csvdat;
				event.preventDefault();
				var csvid = $(this).serialize();

				csvdat = $.ajax({
					url: "process.php?a=sendcsv",
					type: "post",
					data: csvid,
					cache: false
				});

				csvdat.done(function(response, textStatus, jqXHR){
					
					alert(response);
				});

				csvdat.fail(function(){
					$("#tempdata").html("query mislukt");
				});

			});
                        
        });
