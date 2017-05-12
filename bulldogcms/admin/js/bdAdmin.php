//Initiate the tinymce WYSIWYG editor
tinymce.init({
selector: ".editor",

plugins: [
"advlist autolink autosave link responsivefilemanager imagetools lists charmap print preview hr anchor pagebreak spellchecker",
"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
"table contextmenu directionality emoticons template textcolor paste fullpage colorpicker "
],

toolbar1: "bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | formatselect fontselect fontsizeselect | link unlink ",
toolbar2: "responsivefilemanager media | cut copy paste | searchreplace | bullist numlist | outdent indent | undo redo | table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen preview ",
toolbar3: "",

imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io'],
image_advtab: true,

external_filemanager_path:"/admin/filemanager/",
filemanager_title:"Filemanager" ,
external_plugins: { "filemanager" : "./plugins/responsivefilemanager/plugin.min.js"},

menubar: false,
toolbar_items_size: 'small',
content_css: [
'http://fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
'http://www.tinymce.com/css/codepen.min.css'
]
});

tinymce.init({
    selector: ".advancededitor",

    plugins: [
        "advlist autolink autosave link responsivefilemanager imagetools lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "table contextmenu directionality emoticons template textcolor paste fullpage colorpicker "
    ],

    toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | formatselect fontselect fontsizeselect | link unlink anchor responsivefilemanager media code | insertdatetime preview | forecolor backcolor",
    toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking pagebreak restoredraft ",
    toolbar3: "",

    imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io'],
    image_advtab: true,

    external_filemanager_path:"/admin/filemanager/",
    filemanager_title:"Filemanager" ,
    external_plugins: { "filemanager" : "./plugins/responsivefilemanager/plugin.min.js"},

    menubar: false,
    toolbar_items_size: 'small',
    content_css: [
        'http://fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
        'http://www.tinymce.com/css/codepen.min.css'
    ]
});


tinymce.init({ selector:'.basiceditor',
setup: function(editor){
// Hide all the toolbars except the first one
editor.on('BeforeRenderUI', function(e) { editor.theme.panel.find('toolbar').slice(1).hide(); });
// Add a sink button that toggles toolbar 1+ on/off
editor.addButton('sink', { text: 'Kitchen sink', onclick: function() { if (!this.active()) { this.active(true); editor.theme.panel.find('toolbar').slice(1).show(); } else { this.active(false); editor.theme.panel.find('toolbar').slice(1).hide(); } } });
},
elementpath: false,
    plugins: 'autolink textcolor colorpicker charmap image link spellchecker table responsivefilemanager media',
    toolbar1: 'undo redo | formatselect fontselect fontsizeselect | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist table | charmap link unlink | responsivefilemanager media' ,
    toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking pagebreak restoredraft ",
image_advtab: true,

    external_filemanager_path:"/admin/filemanager/",
    filemanager_title:"Filemanager" ,
    external_plugins: { "filemanager" : "./plugins/responsivefilemanager/plugin.min.js"},

    menubar: false
});

//Used on Admin Navigations if Other is chosen to provide text field to manually type website address for link
//Drop down to Text code: https://www.sitepoint.com/community/t/form-drop-down-menus-select-other-and-make-a-textbox-appear/2789
function showOtherURLField(name){
    $("#otherURLDiv").show();
    if(name=='otherURL')document.getElementById('otherURLDiv').innerHTML='<label for="navURL">Other URL(must contain http://):</label><input type="url" class="form-control" name="navURL" required pattern="https?://.+" />';
    else {
        document.getElementById('otherURLDiv').innerHTML = '';
        $("#otherURLDiv").css("display", "none");
        document.getElementById('navURLOld').setAttribute("name", "navURLOld");  //Change Edit URL name so does not save old or blank entry
        $("#navURLOld").css("display", "none");  //Hide extra text box on edit page.
    }
}
//Used on Navigations to create a new URL drop down entry to link to the Navigation's Categories display page
//Copy navigationName:  http://stackoverflow.com/questions/15983012/javascript-onclick-copy-text-field-value-to-drop-down-field
//Example:  http://jsfiddle.net/J8YrU/1/
function copyNavName2() {
    var optn = document.createElement("OPTION");
    optn.text = document.getElementById("navigationName").value + "'s Categories";
    optn.value = "index.php?view=catbynavname&navname=" + document.getElementById("navigationName").value;
    document.getElementById("navURL").options.add(optn);
}

function copyNavName(f) {
    var found = false; //First run through
    for (var i = 0; i < f.navURL.length; i++) {
        if (f.navURL.options[i].value.toLowerCase() === f.navigationName.value.toLowerCase()){
            f.navURL.selectedIndex = i;
            found = true;
            break;
        }
        if (!found) {
            var extraOption = f.navURL.getAttribute("data-extra-option");
            if (extraOption) {
                f.navURL.options[f.navURL.options.length - 1].text = f.navigationName.value + "'s Categories";
                f.navURL.options[f.navURL.options.length - 1].value = "index.php?view=catbynavname&navname=" + f.navigationName.value;
            } else {
                var newOption = new Option(f.navigationName.value, f.navigationName.value);
                f.navURL.setAttribute("data-extra-option", "true");
                f.navURL.appendChild(newOption);
                f.navURL.selectedIndex = f.navURL.options.length - 1;
            }
        } else {
            if (f.navURL.getAttribute("data-extra-option")) {
                f.navURL.removeChild(f.navURL.options[f.navURL.options.length - 1]);
                f.navURL.selectedIndex = 0;
            }
        }
    }
    //var optn = document.createElement("OPTION");
    //optn.text = document.getElementById("navigationName").value + "'s Categories";
    //optn.value = "index.php?view=catbynavname&navname=" + document.getElementById("navigationName").value;
    //document.getElementById("navURL").options.add(optn);
}
jQuery(document).ready(function ($) {
    $('.iframe-btn').fancybox({
        'width'	: 880,
        'height'	: 570,
        'type'	: 'iframe',
        'autoScale'   : false
    });

    //
    // Handles message from ResponsiveFilemanager
    //
    function OnMessage(e){
        var event = e.originalEvent;
        // Make sure the sender of the event is trusted
        if(event.data.sender === 'responsivefilemanager'){
            if(event.data.field_id){
                var fieldID=event.data.field_id;
                var url=event.data.url;
                $('#'+fieldID).val(url).trigger('change');
                $.fancybox.close();

                // Delete handler of the message from ResponsiveFilemanager
                $(window).off('message', OnMessage);
            }
        }
    }

    // Handler for a message from ResponsiveFilemanager
    $('.iframe-btn').on('click',function(){
        $(window).on('message', OnMessage);
    });

    $('#download-button').on('click', function() {
        ga('send', 'event', 'button', 'click', 'download-buttons');
    });
    $('.toggle').click(function(){
        var _this=$(this);
        $('#'+_this.data('ref')).toggle(200);
        var i=_this.find('i');
        if (i.hasClass('icon-plus')) {
            i.removeClass('icon-plus');
            i.addClass('icon-minus');
        }else{
            i.removeClass('icon-minus');
            i.addClass('icon-plus');
        }
    });
});


jQuery(document).ready(function($){
    //Admin Help Panel
        $('.cd-btn').on('click', function(event){
            event.preventDefault();
            $('.cd-panel').addClass('is-visible');
        });
        $('.cd-panel').on('click', function(event){
            if( $(event.target).is('.cd-panel') || $(event.target).is('.cd-panel-close') ) {
                $('.cd-panel').removeClass('is-visible');
                event.preventDefault();
            }
        });

    //turns on tooltips
        $(function () {
        $('[data-toggle="tooltip"]').tooltip()
        });

    //handles page size based on the height of the side nav on page load
        if( $('#page-wrapper').height() < $('.side-nav').height()+50) {
            $('#page-wrapper').css('height', $('.side-nav').height()+50);
        }
});

