/* 设置单选框选中效果 */
(function(){
    var curr = function(target){
        var label = ["red", "green", "yellow", "blue"], obj = [], v;
        for(v in label){
            obj[v] = target.find(".note-edit-" + label[v]);
            obj[v].find("input:checked").length && obj[v].addClass("note-edit-" + label[v] + "-curr");
            obj[v].click(function(){
                for(v in obj){
                   var curr = "note-edit-" + label[v] + "-curr";
                   obj[v].find("input:checked").length ? obj[v].addClass(curr) : obj[v].removeClass(curr);
                }
            });
        }
    };
    curr($(".js-note-add"));
    curr($(".js-note-edit"));
})();

/* 添加按钮 */
$(".note-top-add").click(function(){
    $(".js-note-add").fadeIn(200);
});

/* 取消按钮 */
$(".note-edit-cancel").click(function(){
    $(this).parents(".note-layer").fadeOut(200);
});

/* 删除按钮 */
$(".note-list-delete").click(function(){
    return confirm('您确定要把他删除吗？');
});