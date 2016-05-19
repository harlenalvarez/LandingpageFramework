var selectedColumns = [];
var pageUrl = window.location.protocol+"//"+window.location.hostname;
var strtElement;
var hasEnter = false;
/**
 * Document Ready function
 * @author Harlen Alvarez
 * @param {type} ev
 * @returns {undefined}
 * 
 */

$(function(){
        $('[data-toggle="tooltip"]').tooltip({
                "placement":"right",
                "animated":"fade",
                "template":'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
                "container": "body",
                "delay":{"show":"1000","hide":"50"}
        });
        $( '.scrollDiv' ).on( 'mousewheel', function ( e ) {
            var event = e.originalEvent,
                d = event.wheelDelta || -event.detail;

            this.scrollTop += ( d < 0 ? 1 : -1 ) * 30;
            e.preventDefault();
        });
        

       
});

function hideAlert(element){
    $(element).fadeTo(2000,500).slideUp(500,function(){
        $(element).alert('close');
       
    });
    adjustFooter();
}
function scrollToTop(){
    $("html, body").animate({ scrollTop: 0 }, 500);
}

function scrollToElement(el){
    $("html, body").animate({ scrollTop: $(el).offset().top }, 500);

}

function scrollToElementInsideDiv(el){
    $("html, body").animate({ scrollTop: $(el).position().top }, 500);
}
/*
 * 
 * @param {type} ev
 * @returns {undefined}
 */

function displayReports(ev){
   var target = $(ev.target).closest("div");
   var text = $(target).find("p").html();
  
   if(text == "Companies")
   {
       var columns = [['customer_id','Customer #','center','left','true'],['name','Name','center','left','true'],['state','State','center','left','true'],['city','City','center','left','true']];
       var col = setFields(columns);
       createTable(col);
   }
   else if(text == "Orders")
   {
       
       var columns = [['date','Date','center','left','true'],
                        ['date','Date','center','left','true'],
                        ['program','Program','center','left','true'],
                        ['brand','Brand','center','left','true'],
                        ['company','Company','center','left','true'],
                        ['order_number','Order #','center','left','true'],
                        ['buy_in','Buy-In','center','left','true'],
                        ['advertising','Advertising','center','left','true']];
        var col = setFields(columns);
        createTable(col);
   }
   else if(text == "Reports")
   {
          
        

           $.ajax({
           type: "POST",
           url: "../model_control/getReports",
           data: {"customer_id":customerId},
           cache: false,
           success: function(data)
           {
              $("#tableDiv").html(data);
           },
           error: function(msg)
           { 
               $("#tableDiv").html(msg);
           }
         });
       
    }
  
    function setFields(columns){
      var col = [];
     for(var x = 0;x<columns.length;x++)
     {    
      var sortable = (columns[x][4] == "true")?true:false;
      
        col.push({field:columns[x][0],title:columns[x][1],halign:columns[x][2],align:columns[x][3],sortable:sortable});
      
      
     } 
     return col
     
}
   
    function createTable(col,functionName){
             $('#tableDiv').html("<table id=table-javascript ></table>");
             $('#table-javascript').bootstrapTable({
                method: 'get',
                url: '../../model_control/'+functionName,
                cache: true,
                
                striped: true,
                pagination: true,
                sidePagination:"server",
                showHeader:true,
                pageSize: 10,
                pageList: [10, 25, 50, 100, 200],
                search: true,
                showColumns: true,
                showRefresh: true,
                minimumCountColumns: 2,
                clickToSelect: true,
                columns:col,
                queryParams:  function(){
                               return {
                                    customerID:customerId,
                                    option:text,
                                    limit: this.pageSize,
                                    offset: this.pageSize * (this.pageNumber - 1) 
                                 }}
            
            });
        }  
           
   
    
}

function temp(destinationId,functionName,accessLevel){
    $(destinationId).html("test");
}

function setColumnsForUsers(destinationId, tableId, functionName, accessLevel){
    var columns = [['state',true],
        ['user_id','User Id','center','center','true'],
        ['user_first_name','First Name','center','center','true','true'],
        ['user_last_name','Last Name','center','center','true','true'],
        ['user_name','User Name','center','center','true','false'],
        ['user_access_level','Access Level','center','center','true','true'],
        ['user_main_email','Email','center','center','true','true'],
        ['user_active_yn','User Active','center','center','false','true','false']];
    var col = setFields(columns);
    var submitButton    = $("#editUsersSaveButton");
    var extraButton1    = $("#editUsersRemoveButton");
    createTable(col,destinationId, tableId, functionName, accessLevel, submitButton,extraButton1);
}

//Creates the columns based on the array passed in
function setFields(columns)
{
    var col = [];
    for (var x = 0; x < columns.length; x++)
    {
        if(columns[x][0]=="state"){
            col.push({field:columns[x][0],checkbox:true});
        }
        else
        {
            var sortable = (columns[x][4] == "true") ? true : false;
            var editable = (columns[x][5] == "true")? true: false;
            var check    = (columns[x][6] == "true")? true:false;

            col.push({field: columns[x][0], title: columns[x][1], halign: columns[x][2], align: columns[x][3], sortable: sortable,editable:editable,checkbox:check});
        }
       


    }
    return col;

}

function createTable(col,destinationId, tableId,functionName,accessLevel,submitButton, extraButton1, extraButton2) {
    var tempTableId     = tableId.replace("#","");
    submitButton        = typeof submitButton !== "undefined" ? submitButton: null;
    extraButton1        = typeof extraButton1 !== "undefined" ? extraButton1: null;
    extraButton2        = typeof extraButton2 !== "undefined" ? extraButton2: null;
    $(destinationId).html("<table id="+tempTableId+"></table>");
    $(tableId).bootstrapTable({
        method: 'get',
        url: pageUrl + functionName,
        cache: true,
        striped: true,
        pagination: true,
        pageNumber:1,
        sidePagination: "server",
        showHeader: true,
        pageSize: 10,
        pageList: [10, 25, 50, 100, 200],
        search: true,
        editable:true,
        showColumns: true,
        showRefresh: true,
        showExport: true,
        smartDisplay:true,
        resizable:true,
        showToggle:true,
        clickToSelect:false,
        minimumCountColumns: 2,
        columns: col,
        queryParams: function () {
            return {
                accessLevel: accessLevel,
                search: $(".search > input[type='text']").val(),
                orderBy: this.sortName,
                orderType: this.sortOrder,
                limit: this.pageSize,
                offset: this.pageSize * (this.pageNumber - 1)
            }
        },
        onClickRow: function (row) {
           
        },
        onLoadSuccess: function ()
        {
            adjustFooter();
        },
        onCheck:function(row){
            if(!containsObject(row,selectedColumns)){
                 selectedColumns.push(row);
            }
            if(submitButton !== null){
                submitButton.removeAttr("disabled");
            }
            if(extraButton1 !== null){
                extraButton1.removeAttr("disabled");
            }
            if(extraButton2 !== null){
                extraButton2.removeAttr("disabled");
            }
        },
        onUncheck:function(row){
            var index   = selectedColumns.indexOf(row);
            selectedColumns.splice(index,1);
            if(selectedColumns.length < 1){
                if(submitButton !== null){
                    submitButton.attr("disabled","disabled");
                }
                if(extraButton1 !== null){
                    extraButton1.attr("disabled","disabled");
                }
                if(extraButton2 !== null){
                    extraButton2.attr("disabled","disabled");
                }
            }
            
        },
        onUncheckAll:function(){
            selectedColumns   = [];
            if(submitButton !== null){
                submitButton.attr("disabled","disabled");
            }
            if(extraButton1 !== null){
                extraButton1.attr("disabled","disabled");
            }
            if(extraButton2 !== null){
                extraButton2.attr("disabled","disabled");
            }
        },
        onCheckAll:function(rows){
            var x;
            for(x = 0; x < rows.length; x++){
                if(!containsObject(rows[x],selectedColumns)){
                    selectedColumns.push(rows[x]);
                }
            }
            if(submitButton !== null){
                submitButton.removeAttr("disabled");
            }
            if(extraButton1 !== null){
                extraButton1.removeAttr("disabled");
            }
            if(extraButton2 !== null){
                extraButton2.removeAttr("disabled");
            }
        },
        onEditableSave:function(field,row,index){
          $(tableId).bootstrapTable("check",index); 
        }

    });
}
function reloadBootstrapTable(tableId){
    $("#"+tableId).bootstrapTable("refresh",{"silent":"true"});
}
function containsObject(obj, list) {
    var i;
    for (i = 0; i < list.length; i++) {
        if (list[i] === obj) {
            return true;
        }
    }

    return false;
}

        /**
         * Password Visual Guide
         * @author Harlen Alvarez
         * @returns {undefined}
         * Visual guide while changing passwords
         */
function readyRead(){
    
    $("#newPassword").keyup(function(){
            var pass = $("#newPassword").val();
            if(pass.length >= 8)
            {
                $("#pLength").removeClass("glyphicon-remove text-danger").addClass("glyphicon-ok text-success");
            }
            else
            {
                $("#pLength").removeClass("glyphicon-ok text-success").addClass("glyphicon-remove text-danger");
            }
            if(pass.match(/[a-z]/))
            {
                $("#pLower").removeClass("glyphicon-remove text-danger").addClass("glyphicon-ok text-success");
            }
            else
            {
                $("#pLower").removeClass("glyphicon-ok text-success").addClass("glyphicon-remove text-danger");
            }
            if(pass.match(/[A-Z]/))
            {
                $("#pUpper").removeClass("glyphicon-remove text-danger").addClass("glyphicon-ok text-success");
            }
            else
            {
                $("#pUpper").removeClass("glyphicon-ok text-success").addClass("glyphicon-remove text-danger");
            }
            if(pass.match(/[0-9]/))
            {
                $("#pNumber").removeClass("glyphicon-remove text-danger").addClass("glyphicon-ok text-success");
            }
            else
            {
                $("#pNumber").removeClass("glyphicon-ok text-success").addClass("glyphicon-remove text-danger");
            }
            if(pass.match(/[^0-9a-zA-Z]/))
            {
                $("#pSymbol").removeClass("glyphicon-remove text-danger").addClass("glyphicon-ok text-success");
            }
            else
            {
                $("#pSymbol").removeClass("glyphicon-ok text-success").addClass("glyphicon-remove text-danger");
            }
        });
        $("#confirmPassword").keyup(function(){
            var pass = $("#newPassword").val();
            var conPass = $("#confirmPassword").val();
            
            if(pass === conPass && pass!== "")
            {
                $("#pMatch").removeClass("glyphicon-remove text-danger").addClass("glyphicon-ok text-success");
            }
            else
            {
                $("#pMatch").removeClass("glyphicon-ok text-success").addClass("glyphicon-remove text-danger");
            }
        });
    
}

/***
 * 
 */
 function passwordDisplay(newPasswordId,confirmPasswordId,displayId){
    
    $(newPasswordId).keyup(function(){
            var pass = $(newPasswordId).val();
            if(pass.length >= 8)
            {
                $("#pLength"+displayId).removeClass("glyphicon-remove text-danger").addClass("glyphicon-ok text-success");
            }
            else
            {
                $("#pLength"+displayId).removeClass("glyphicon-ok text-success").addClass("glyphicon-remove text-danger");
            }
            /*if(pass.match(/[a-z]/))
            {
                $("#pLower"+displayId).removeClass("glyphicon-remove text-danger").addClass("glyphicon-ok text-success");
            }
            else
            {
                $("#pLower"+displayId).removeClass("glyphicon-ok text-success").addClass("glyphicon-remove text-danger");
            }
            if(pass.match(/[A-Z]/))
            {
                $("#pUpper"+displayId).removeClass("glyphicon-remove text-danger").addClass("glyphicon-ok text-success");
            }
            else
            {
                $("#pUpper"+displayId).removeClass("glyphicon-ok text-success").addClass("glyphicon-remove text-danger");
            }
            if(pass.match(/[0-9]/))
            {
                $("#pNumber"+displayId).removeClass("glyphicon-remove text-danger").addClass("glyphicon-ok text-success");
            }
            else
            {
                $("#pNumber"+displayId).removeClass("glyphicon-ok text-success").addClass("glyphicon-remove text-danger");
            }
            if(pass.match(/[^0-9a-zA-Z]/))
            {
                $("#pSymbol"+displayId).removeClass("glyphicon-remove text-danger").addClass("glyphicon-ok text-success");
            }
            else
            {
                $("#pSymbol"+displayId).removeClass("glyphicon-ok text-success").addClass("glyphicon-remove text-danger");
            }*/
        });
        $(confirmPasswordId).keyup(function(){
            var pass    = $(newPasswordId).val();
            var conPass = $(confirmPasswordId).val();
            
            if(pass === conPass && pass!== "")
            {
                $("#pMatch"+displayId).removeClass("glyphicon-remove text-danger").addClass("glyphicon-ok text-success");
            }
            else
            {
                $("#pMatch"+displayId).removeClass("glyphicon-ok text-success").addClass("glyphicon-remove text-danger");
            }
        });
    
}

/**
 * Drag and Drop Controls
 * @author Harlen Alvarez
 * This is a set of independent functions that handle different types of drags and drops
 * */


function dragStart(event) {
    var element         = event.target.parentElement.outerHTML;
    event.dataTransfer.setData("text/html", element);
    strtElement = event;
}

function dragStartPage(event,viewId){
    event.dataTransfer.setData("text/html",event.target.id);
    strtElement = event.target;
    hideView(viewId);
}

function allowDrop(event) {
    event.preventDefault();
    return false;
}

function allowSpecialDrop(event){
    event.preventDefault();
}

function drop(event) {
    event.preventDefault();
    event.stopPropagation();
    if (strtElement.target.id !== event.target.id) {
        var data = event.dataTransfer.getData("text/html");
        var id  = "#"+event.target.id;
        var oldLocation = "#"+strtElement.target.offsetParent.parentElement.id;
        var divToRemove = "#"+strtElement.target.parentElement.id;
        $(divToRemove).remove();
        $(id).append(data);
       
    }
    return false;
}



/*
 * Drop Into trash can
 */
function dropInTrash(event) {
    event.preventDefault();
    event.stopPropagation();
    if (strtElement.id !== event.target.id) {
        var id      = "#"+strtElement.id;
        var data    = event.dataTransfer.getData("text/html");
        $("#trashCan").append(document.getElementById(data));
        if($(id).has("button").length){
            
        }else
        {
           $(id).append("<button onclick='restoreFromTrashCan(this)'>Restore</button>");
        }
                
    }
    return false;
}
/*
 * Swap spaces with another element
 */
function dropReplace(event) {
    event.preventDefault();
    event.stopPropagation();
    var data = event.dataTransfer.getData("text/html");
    if (strtElement.id !== event.target.id) {
       event.target.html(document.getElementById(data));

    }
}

function dropAndSwap(event){
    event.preventDefault();
    event.stopPropagation();
    var data = event.dataTransfer.getData("text/html");
    if (strtElement.id !== event.target.id) {
        strtElement = this.innerHtml;
        this.innerHtml = data;

    }
}


/**
 * Helper functions to call directly from elements
 */

function showAndHideResponse(divId,htmlMsg){
    showResponse(divId,htmlMsg);
    hideAlert(htmlMsg);
}

function showResponse(divId, htmlMsg){
    $("#"+divId).html(htmlMsg);
    scrollToElement("#"+divId);
}





// 4. The API will call this function when the video player is ready.
function onPlayerReady(event) {
    event.target.playVideo();
}

// 5. The API calls this function when the player's state changes.
//    The function indicates that when playing a video (state=1),
//    the player should play for six seconds and then stop.
var done = false;
function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.PLAYING && !done) {
        setTimeout(stopVideo, 6000);
        done = true;
    }
}
function stopVideo() {
    player.stopVideo();
}

function youtubeControlSlide(event,slideId){
    if (event.data == YT.PlayerState.PLAYING && !done) {
        alert("Playing");
       //$("#"+slideId).carousel("pause");
    }else{
       // $("#"+slideId).carousel();
    }
}

function hasValue(val){
    console.log(val);
    console.log(typeof(val));
    return true;
}

function loadVideoInPane(paneId,videoId){
    var iframe = document.createElement("iframe");
    iframe.setAttribute("src","https://www.youtube.com/embed/"+videoId+"?autoplay=1&autohide=2&border=0&wmode=opaque&enablejsapi=1&controls=1&showinfo=0");
    iframe.setAttribute("frameborder","0");
    iframe.setAttribute("allowfullscreen","true");
    iframe.setAttribute("width","560px");
    iframe.setAttribute("height","315px");
    iframe.setAttribute("id",paneId+"-"+videoId);
    $("#"+paneId).html(iframe);
}

function extractUrl(fullUrl){
    var url = "";
    url = fullUrl.match(/^\b(?:(?:https?|ftps?):\/\/|www\.)*[-a-z0-9+&@#\.]+\.[a-zA-Z]{2,4}\/[-a-zA-Z0-9+&@#%=~_|]+\/[-a-zA-Z0-9+&@#%=~_|]+/i);
    return url;
}
function showModal(modalId){
    $("#"+modalId).modal({
        backdrop:'static',
        keyboard:false,
        show:true
    });
}

function closeModal(modalId){
    $("#"+modalId).modal("hide");
}

function showLoading(msg){
    $("#loadingModalMessage").html(msg);
    $("#loadingModal").modal({
        backdrop:'static',
        keyboard:false,
        show:true
    });
}

function closeLoading(){
    $("#loadingModal").modal('hide');
}

function viewImage(urlPath){
    $('#pageModalBody').html("<img src='"+urlPath+"'/>");
    $("#pageModalBody").css("min-height","90vh");
    $("#pageModal").modal('show');
}

function viewPDF(pdf_path){
   
    var iframe = document.createElement("iframe");
    var iframeSrc = "views/resources/jsplugins/pdfviewer/web/viewer.html?file="+pdf_path;
    iframe.setAttribute("src",iframeSrc);
    iframe.setAttribute("height","100%");
    iframe.setAttribute("width","100%");
    $('#pageModalBody').html(iframe);
    $("#pageModalBody").css("height","90vh");
    $("#pageModal").modal('show');
    
}

function uploadFile(elementId, displayId){
    
    $("#"+elementId).click();
    $("#"+elementId).change(function(){
        var filename = "";
        var filesize = 0;
        var innerHtml = "";
        var tempHtml = "";
        var reader = [];
        if(window.File && window.FileReader && window.FileList && window.Blob){

            for(var x = 0; x < this.files.length;x++){
                filename = this.files[x].name;
                filesize = this.files[x].size;
                if(filesize < 5000000)
                {
                    if(this.files && this.files[x]){
                        reader[x] = new FileReader();
                        reader[x].onload = function(e){
                            if(e.target.result.match(/image/i)){
                                tempHtml = "<img height='150px' src='"+e.target.result+"' alt = '"+filename+"'/>";
                            }
                            else if(e.target.result.match(/pdf/i)){
                                tempHtml = document.createElement("iframe");
                                tempHtml.setAttribute("src",e.target.result);
                                tempHtml.setAttribute("height","150px");
                                tempHtml.setAttribute("width","100px");
                                tempHtml.setAttribute("frameborder","0");
                                tempHtml.setAttribute("scrolling","no");


                            }
                            innerHtml += tempHtml;
                            $("#"+displayId).html(innerHtml);
                        }
                        reader.onerror = function(){
                            innerHtml += filename;
                            reader.abort();

                        }
                        reader[x].readAsDataURL(this.files[x]);
                    }
                }
                else{
                    innerHtml += filename;
                    $("#"+displayId).html(innerHtml);
                }
            }

        }


    });
}
/*
 * NG APPS
 */
//ANGULAR JS MODULES AND DIRECTIVES
var rootApp = angular.module("rootApp",['ngAnimate']).config(function($locationProvider,$compileProvider){
    $locationProvider.html5Mode({ enabled: true, requireBase: false, rewriteLinks:false});
    $compileProvider.aHrefSanitizationWhitelist(/^\s*(https?|ftp|mailto|chrome-extension|tel|javascript):/);
});
rootApp.filter('rawHtml', ['$sce', function($sce){
    return function(val) {

        return $sce.trustAsHtml(val);
    };
}]);
rootApp.filter("dFormatFilter",function(){
    return function(val){
        var parsedValue;
        parsedValue = parseFloat(val);
        if(isNaN(parsedValue)){
            return val;
        }
        else{
            return "$"+parsedValue.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
    }
});
rootApp.filter('textDate',function(){
    return function(val){
        var parsedDate = moment().format(val,'MMMM Do YYYY');
        if(parsedDate == "Invalid date"){
            return val;
        }
        else{
            return parsedDate;
        }
    }
});
rootApp.directive("fileread", [function () {
    return {
        scope: {
            fileread: "="
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
                var reader = new FileReader();
                reader.onload = function (loadEvent) {
                    scope.$apply(function () {
                        scope.fileread = loadEvent.target.result;
                    });
                }
                reader.readAsDataURL(changeEvent.target.files[0]);
            });
        }
    }
}]);
rootApp.directive('ngFinishrepeat', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {

            if (scope.$last === true) {
                $timeout(function () {
                    scope.$emit('ngRepeatFinished');
                });
            }
        }
    }
});
rootApp.directive("ngValidate",function(){
    return{
        restrict:"A",
        require:"ngModel",
        link:function($scope,$element,$attrs, ngModel){
            $scope.$watch($attrs.ngModel,function(value){
                switch($attrs.ngValidate){
                    case "isUrl":
                        var reg = new RegExp(/^\b(?:(?:https?|ftps?):\/\/|www\.)*[-a-z0-9+&@#\.]+\.[a-zA-Z]{2,64}((\/|\?)[-a-z0-9+&@#\/%?=~_|!:,.;\s]*[-a-z0-9+&@#\/%=~_|])*$/i);
                        ngModel.$setValidity("ngIsurl",(reg.testExp(value)||ngModel.$pristine));
                        break;
                    case "isEmail":
                        var reg = new RegExp(/^([0-9a-zA-Z\-_])+(\.[0-9a-zA-Z\-_]+)*@([0-9a-zA-Z])+(\.[0-9a-zA-Z]+)*\.[a-zA-Z]{2,4}(\.[a-zA-Z]{2,64})*$/i);
                        ngModel.$setValidity("ngIsemail",(reg.testExp(value)||ngModel.$pristine));
                        break;
                    case "isPhone":
                        if(typeof(value) !== "undefined" || value !== ""){
                            var reg = new RegExp(/^[0-9]{3}-[0-9]{3}-[0-9]{4}(\s*x[\d]+)*$/);
                            ngModel.$setValidity("ngIsphone",(reg.testExp(value)||ngModel.$pristine));
                        }
                        break;
                    case "isZip":
                        var regString = "^\\d{"+$attrs.ngZip+"}$";
                        var reg = new RegExp(regString);
                        ngModel.$setValidity("ngZip",(reg.testExp(value)||ngModel.$pristine));
                        break;
                }
            });
        }
    }
});
rootApp.directive("ngCompare",function(){
   return{
       restrict:"A",
       require:"ngModel",
       link: function($scope, $element, $attrs, ngModel){
           $attrs.$observe('ngCompare', function(value){
               
               var result   = (value === ngModel.$viewValue);
               ngModel.$setValidity("ngCompare", result);
           });
           
           $scope.$watch($attrs.ngModel,function(value){
              var result = (value === $attrs.ngCompare);
              ngModel.$setValidity("ngCompare",result);
           });
       }
   } 
});
rootApp.directive("ngIsurl",function(){
    return{
        restrict: "A",
        require:"ngModel",
        link: function($scope, $element, $attrs, ngModel){
            $scope.$watch($attrs.ngModel,function(value){
                var reg = new RegExp(/^\b(?:(?:https?|ftps?):\/\/|www\.)*[-a-z0-9+&@#\.]+\.[a-zA-Z]{2,64}((\/|\?)[-a-z0-9+&@#\/%?=~_|!:,.;\s]*[-a-z0-9+&@#\/%=~_|])*$/i);
                ngModel.$setValidity("ngIsurl",(reg.testExp(value)||ngModel.$pristine));
            });
        }
    };
});
rootApp.directive("ngZip",function(){
    return{
        restrict:"A",
        require:"ngModel",
        link: function($scope, $element, $attrs, ngModel){
            $scope.$watch($attrs.ngModel,function(value){
                var regString = "^\\d{"+$attrs.ngZip+"}$";
                var reg = new RegExp(regString);
                ngModel.$setValidity("ngZip",(reg.testExp(value)||ngModel.$pristine));
            });
        }
    };
});
rootApp.directive("ngFormat",function(){
    return{
        restrict:"A",
        require:"ngModel",
        link: function($scope,$element, $attrs, ngModel){

            $scope.$watch($attrs.ngModel,function(value){
                if(typeof(value) !== "undefined"){
                    var reg = null;
                    var returnValue = "";
                    switch($attrs.ngFormat){
                        case "phone":
                            returnValue = value.replace(/(\d{3}(?=\d{3})|x\d*)/g,"$&-");
                            returnValue = returnValue.replace(/\-$/,'');
                            break;
                        case "dollar":
                            var parsedValue = parseFloat(value);
                            if(isNaN(parsedValue)){
                                returnValue = value;
                            }
                            else{
                                returnValue = "$"+parsedValue.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                            }

                            break;
                    }

                    if(typeof(returnValue)!=="undefined"||returnValue !== ""){
                        ngModel.$setViewValue(returnValue);
                        ngModel.$render();
                    }

                }
            });
        }
    };
});
rootApp.directive("ngIsphone",function(){
    return{
        restrict:"A",
        require:"ngModel",
        link: function($scope, $element, $attrs, ngModel){
            $scope.$watch($attrs.ngModel,function(value){
                if(typeof(value) !== "undefined" || value !== ""){
                    var reg = new RegExp(/^[0-9]{3}-[0-9]{3}-[0-9]{4}(\s*x[\d]+)*$/);
                    ngModel.$setValidity("ngIsphone",(reg.testExp(value)||ngModel.$pristine));
                }
            });
            
        }
    };
});
rootApp.directive("ngRound",function(){
    return{
        restrict:"A",
        require:"ngModel",
        link: function($scope,$element, $attrs, ngModel){

            $scope.$watch($attrs.ngModel,function(value){
                if(typeof(value) !== "undefined"){
                    var reg = null;
                    var returnValue = "";
                    var roundN = parseInt($attrs.ngRound);
                    var parsedValue = parseFloat(value);
                    if(isNaN(parsedValue) || isNaN(roundN)){
                        returnValue = value;
                    }
                    else{

                        returnValue = parsedValue.toFixed(roundN).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                    }
                    if(typeof(returnValue)!=="undefined"||returnValue !== ""){
                        ngModel.$setViewValue(returnValue);
                        ngModel.$render();
                    }

                }
            });
        }
    };
});
rootApp.directive("ngIsemail",function(){
    return{
        restrict:"A",
        require:"ngModel",
        link:function(scope,el,attr,ngModel){
            scope.$watch(attr.ngModel,function(value){
                var reg = new RegExp(/^([0-9a-zA-Z\-_])+(\.[0-9a-zA-Z\-_]+)*@([0-9a-zA-Z])+(\.[0-9a-zA-Z]+)*\.[a-zA-Z]{2,4}(\.[a-zA-Z]{2,64})*$/i);
                ngModel.$setValidity("ngIsemail",(reg.testExp(value)||ngModel.$pristine));
            
            });
        }
    };
});
rootApp.directive("ngHasupper",function(){
    return{
        restrict:"A",
        require:"ngModel",
        link: function($scope, $element, $attrs, ngModel){
            $scope.$watch($attrs.ngModel,function(value){
                var q = $attrs.ngHasupper;
                var reg = "[A-Z]{"+q+",}";
                reg = new RegExp(reg);
                ngModel.$setValidity("ngHasupper",(reg.testExp(value)||ngModel.$pristine));
            });
        }
    };
});
rootApp.directive("ngHaslower",function(){
    return{
        restrict:"A",
        require:"ngModel",
        link: function($scope, $element, $attrs, ngModel){
            $scope.$watch($attrs.ngModel,function(value){
                var q = $attrs.ngHaslower;
                var reg = "[a-z]{"+q+",}";
                reg = new RegExp(reg);
                ngModel.$setValidity("ngHaslower",(reg.testExp(value)||ngModel.$pristine));
            });
        }
    };
});
rootApp.directive("ngHasnumber",function(){
    return{
        restrict:"A",
        require:"ngModel",
        link: function($scope, $element, $attrs, ngModel){
            $scope.$watch($attrs.ngModel,function(value){
                var q = $attrs.ngHasnumber;
                var reg = "[0-9]{"+q+",}";
                reg = new RegExp(reg);
                ngModel.$setValidity("ngHasnumber",(reg.testExp(value)||ngModel.$pristine));
            });
        }
    };
});
rootApp.directive("ngHaschar",function(){
     return{
        restrict:"A",
        require:"ngModel",
        link: function($scope, $element, $attrs, ngModel){
            $scope.$watch($attrs.ngModel,function(value){
                var q = $attrs.ngHaschar;
                var reg = "[^a-zA-Z0-9]{"+q+",}";
                reg = new RegExp(reg);
                ngModel.$setValidity("ngHaschar",(reg.testExp(value)||ngModel.$pristine));
            });
        }
    };
});






/**
 * @param string
 * @returns bool
 */
RegExp.prototype.testExp = function(value){
    var result = true;
    if(value && typeof(value) !== "undefined"){
        result = this.test(value);
    }
    return result;
};
