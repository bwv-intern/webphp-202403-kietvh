$(function(){$("#started-date-from").datepicker({dateFormat:"dd/mm/yy",onSelect:function(e){$("#started-date-from").valid()}}),$("#started-date-to").datepicker({dateFormat:"dd/mm/yy",onSelect:function(e){$("#started-date-from").valid()}}),$("#formSearch").validate({rules:{name:{maxlength:100},started_date_from:{dateDMY:!0,startDateBeforeEndDate:!0},started_date_to:{dateDMY:!0,greaterStart:"#started_date_from"}},messages:{started_date_to:{dateDMY:"Started Date Toは日付を正しく入力してください。"},started_date_from:{dateDMY:"Started Date Fromは日付を正しく入力してください。"}}}),$("#btnClear").click(function(){$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},url:"/admin/user/clear",type:"post",dataType:"json",success:function(e){console.log(e),e.hasError==!1&&($("#formSearch").trigger("reset"),$("#formSearch").find("input:text, input:password, input:file, textarea").val("").removeClass("error-message"),$(".error-message").remove(),window.history.pushState(null,"","/admin/user"))}})}),$("#btnNew").click(function(e){window.location.href="/admin/user/add-edit-delete"}),$("#btnExport").click(function(e){}),window.setInterval(function(){var e=$.cookie("exported");e&&(_common.showLoading(!1),$.removeCookie("exported",{path:"/"}))},1e3),$("option").each(function(){console.log("OK");var e=$(this).text();e.length>20&&(e=e.substring(0,19)+"...",$(this).text(e))})});
