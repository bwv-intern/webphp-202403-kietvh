$(function(){window.onpageshow=function(e){e.persisted&&window.location.reload()};var a={},r={};$.extend(window,{_common:a,_messages:r}),$.ajaxSetup({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")}}),$("input").keypress(function(){$(".alert-danger").hide()});function n(e=!0){$("button[type='submit']").prop("disabled",e),e?$("#loading").show():$("#loading").hide()}a.showLoading=n;function o(e){return e===void 0||e==null||e.length<=0}a.isEmpty=o;function d(e,t){e.rules("add",t)}a.addValidate=d;function c(e,t){e.rules("remove",t),i(e)}a.removeValidate=c;function i(e){e.removeClass("error-message"),$("#"+e.attr("id")+"-error").remove()}a.removeErrorMessage=i,$(".btn-clear-search").click(function(){var e=$(this).closest("form"),t=e.find(".i-radio"),l=e.find(".datepicker")?e.find(".date-month"):"";e.trigger("reset"),e.find("input:text, input:password, input:file, textarea").val(""),e.find(".i-radio, .i-checkbox").closest("div").removeClass("checked"),e.find(".i-radio, .i-checkbox").removeAttr("checked"),e.find("select").each(function(){var s=$(this).find("option:first").val();$(this).val(s),$(this).trigger("change"),$(this).trigger("chosen:updated")}),e.find(".select-with-search").val(""),t.closest(".check").data("default")&&t.each(function(){$(this).val()==t.closest(".check").data("default")&&($(this).attr("checked",!0),$(this).closest("div").addClass("checked"),$(this).trigger("change"))}),l.each(function(){$(this).data("default")&&$(this).data("is-default")?$(this).val($(this).data("default")):$(this).val("")}),$("form").valid(),$.ajax({headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},url:$(this).data("url"),type:"get",data:{screen:$(this).data("screen")},dataType:"json",success:function(s){}})})});
