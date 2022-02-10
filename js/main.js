	$(document).ready(function(){
   		var postcount;
    	$(document).on("click", ".sbmt", function(){
        	postcount = $(this).attr("name");
        	alert(postcount);
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
         		// show succes message
         		$("#result").html('event succesvol aangemaakt');
                
            	$("#selectevent").load(location.href+" #selectevent>*","");
                $("#createevent").load(location.href+" #createevent>*","");
                
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
            	var postrequest;
            	event.preventDefault();
            	var pvalues = $(this).serialize();
            	
            	postrequest = $.ajax({
                	url: "process.php?a=prestock",
                	type: "post",
                	data: pvalues,
                	cache: false
                });
            
            	postrequest.done(function (response, textStatus, jqXHR){
                	$("#tmp").html("Begintelling succesvol opgeslagen");
                	$("#prestock").hide();
                });
            
            	postrequest.fail(function(){
                	$("#tmp").html("there is something wrong");	
                });
            
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
					$("#tmp").html("De eindtelling is succesvol opgeslagen");
					$("#pcount").hide();
				
				});

				updatestock.fail(function(){
					$("#tmp").html("Er is iets niet goed");
				});

			});
                        
        });
