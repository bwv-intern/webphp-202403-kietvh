$(document).ready(function(){$('#formImportCSV input[type="file"]').on("change",function(){$(this).valid()}),$("#formImportCSV").validate({rules:{csvFile:{required:!0,extension:"csv",fileSize:2*1024*1024}},messages:{csvFile:{required:"File は必須です。",extension:function(e){return jQuery.validator.messages.extension("CSV")},fileSize:function(e,t){var n=e/1024/1024;return"ファイルのサイズ制限"+n+"を超えています。"}}}});var i=$("#errorList"),r=i.find("li").length>0;r&&$("#errorModal").modal("show")});
