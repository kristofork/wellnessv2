    admin.typeahead = function(){
        var people = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            limit: 10,
            remote: '/people?firstname=%QUERY'
        });
 
        people.initialize();

        $('#name_search').typeahead(null, {
            name: 'people',
            displayKey: 'name',
            source: people.ttAdapter(),
            minLength: 3,
            templates: {
            empty: [
                '<div class="empty-message">',
                'Sorry, could not locate that.',
                '</div>'
            ].join('\n'),
            suggestion: Handlebars.compile(
                         "<a href='admin/{{id}}/edit' class='typeahead_wrapper'>"
                         + "<img class='typeahead_photo' src='{{pic}}' />"
                         + "<div class='typeahead_labels'>"
                         + "<div class='typeahead_primary'>{{name}}</div>"
                         + "<div class='typeahead_secondary'>{{name}}</div>"
                         + "</div>"
                         + "</a>")
            } //end of template

        });
    } // end of typeahead function