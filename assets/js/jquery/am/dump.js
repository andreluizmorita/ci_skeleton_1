function dump(obj) {
	    var out = '<pre>';
	    for (var i in obj) {
	        out += i + ": " + obj[i] + "\n";
	    }
	    
	    out += '</pre>';
	    
	    $("body").prepend(out);
	    
	    
	    //alert(out);
	}