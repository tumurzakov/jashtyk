Function.prototype.bind = function(obj, arg) { 
    var method = this;
    var temp = function() { 
        var args = [];
        for( var i = 0; i<arguments.length; i++ ) {
            args.push( arguments[i] );
        }
        args.push( arg );
        return method.apply(obj, args); 
    }; 

    return temp; 
}

