$.validator.addMethod("dateDMY",function(a,t){return this.optional(t)||/^\d{2}\/\d{2}\/\d{4}$/.test(a)},function(a,t){return $.validator.format("{0}は日付を正しく入力してください。",[$(t).data("label")])});
