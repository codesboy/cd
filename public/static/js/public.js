var _menus = {
    "menus": [{
        "menuid": "1",
        "icon": "icon-sys",
        "menuname": "网电咨询",
        "menus": [{
            "menuid": "12",
            "menuname": "网电咨询",
            "icon": "icon-page",
            "url": "menu1/treegrid.html"
        }, {
            "menuid": "13",
            "menuname": "咨询统计",
            "icon": "icon-class",
            "url": "menu1/class.html"
        }, {
            "menuid": "14",
            "menuname": "菜单",
            "icon": "icon-role",
            "url": "demo2.html"
        }, {
            "menuid": "15",
            "menuname": "菜单",
            "icon": "icon-set",
            "url": "demo.html"
        }, {
            "menuid": "16",
            "menuname": "菜单",
            "icon": "icon-log",
            "url": "demo1.html"
        }]
    }, {
        "menuid": "8",
        "icon": "icon-sys",
        "menuname": "项目设计",
        "menus": [{
            "menuid": "21",
            "menuname": "项目分析",
            "icon": "icon-nav",
            "url": "menu2/tree2.html"
        }, {
            "menuid": "22",
            "menuname": "菜单",
            "icon": "icon-nav",
            "url": "demo1.html"
        }]
    }, {
        "menuid": "56",
        "icon": "icon-sys",
        "menuname": "菜单",
        "menus": [{
            "menuid": "31",
            "menuname": "菜单",
            "icon": "icon-nav",
            "url": "demo1.html"
        }, {
            "menuid": "32",
            "menuname": "菜单",
            "icon": "icon-nav",
            "url": "demo2.html"
        }]
    }, {
        "menuid": "28",
        "icon": "icon-sys",
        "menuname": "菜单",
        "menus": [{
            "menuid": "41",
            "menuname": "菜单",
            "icon": "icon-nav",
            "url": "demo.html"
        }, {
            "menuid": "42",
            "menuname": "菜单",
            "icon": "icon-nav",
            "url": "demo1.html"
        }, {
            "menuid": "43",
            "menuname": "菜单",
            "icon": "icon-nav",
            "url": "demo2.html"
        }]
    }, {
        "menuid": "39",
        "icon": "icon-sys",
        "menuname": "菜单",
        "menus": [{
            "menuid": "51",
            "menuname": "菜单",
            "icon": "icon-nav",
            "url": "demo.html"
        }, {
            "menuid": "52",
            "menuname": "菜单",
            "icon": "icon-nav",
            "url": "demo1.html"
        }, {
            "menuid": "53",
            "menuname": "菜单",
            "icon": "icon-nav",
            "url": "demo2.html"
        }]
    }]
};
//设置登录窗口
function openPwd() {
    $('#w').window({
        title: '修改密码',
        width: 300,
        modal: true,
        shadow: true,
        closed: true,
        height: 160,
        resizable: false
    });
}
//关闭登录窗口
function closePwd() {
    $('#w').window('close');
}



//修改密码
function serverLogin() {
    var $newpass = $('#txtNewPass');
    var $rePass = $('#txtRePass');

    if ($newpass.val() == '') {
        msgShow('系统提示', '请输入密码！', 'warning');
        return false;
    }
    if ($rePass.val() == '') {
        msgShow('系统提示', '请在一次输入密码！', 'warning');
        return false;
    }

    if ($newpass.val() != $rePass.val()) {
        msgShow('系统提示', '两次密码不一至！请重新输入', 'warning');
        return false;
    }

    $.post('/ajax/editpassword.ashx?newpass=' + $newpass.val(), function(msg) {
        msgShow('系统提示', '恭喜，密码修改成功！<br>您的新密码为：' + msg, 'info');
        $newpass.val('');
        $rePass.val('');
        close();
    })

}

$(function() {

    openPwd();

    $('#editpass').click(function() {
        $('#w').window('open');
    });

    $('#btnEp').click(function() {
        serverLogin();
    })

    $('#btnCancel').click(function() {
        closePwd();
    })

    $('#loginOut').click(function() {
        $.messager.confirm('系统提示', '您确定要退出本次登录吗?', function(r) {

            if (r) {
                location.href = '/ajax/loginout.ashx';
            }
        });
    })
});
