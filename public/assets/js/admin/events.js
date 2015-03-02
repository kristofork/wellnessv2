admin.events = function() {
    
           $('#name_search').bind('typeahead:selected', function(obj, data, name) { 
            console.log(data);
        });
    
}