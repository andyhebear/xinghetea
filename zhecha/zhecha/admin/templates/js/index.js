$(function() {
//布局换色设置
    var bgColorSelectorColors = [{ c: '#981767', cName: '' }, { c: '#AD116B', cName: '' }, { c: '#B61944', cName: '' }, { c: '#AA1815', cName: '' }, { c: '#C4182D', cName: '' }, { c: '#D74641', cName: '' }, { c: '#ED6E4D', cName: '' }, { c: '#D78A67', cName: '' }, { c: '#F5A675', cName: '' }, { c: '#F8C888', cName: '' }, { c: '#F9D39B', cName: '' }, { c: '#F8DB87', cName: '' }, { c: '#FFD839', cName: '' }, { c: '#F9D12C', cName: '' }, { c: '#FABB3D', cName: '' }, { c: '#F8CB3C', cName: '' }, { c: '#F4E47E', cName: '' }, { c: '#F4ED87', cName: '' }, { c: '#DFE05E', cName: '' }, { c: '#CDCA5B', cName: '' }, { c: '#A8C03D', cName: '' }, { c: '#73A833', cName: '' }, { c: '#468E33', cName: '' }, { c: '#5CB147', cName: '' }, { c: '#6BB979', cName: '' }, { c: '#8EC89C', cName: '' }, { c: '#9AD0B9', cName: '' }, { c: '#97D3E3', cName: '' }, { c: '#7CCCEE', cName: '' }, { c: '#5AC3EC', cName: '' }, { c: '#16B8D8', cName: '' }, { c: '#0099CC', cName: ''}, { c: '#49B4D6', cName: '' }, { c: '#6DB4E4', cName: '' }, { c: '#8DC2EA', cName: '' }, { c: '#BDB8DC', cName: '' }, { c: '#8381BD', cName: '' }, { c: '#7B6FB0', cName: '' }, { c: '#AA86BC', cName: '' }, { c: '#AA7AB3', cName: '' }, { c: '#935EA2', cName: '' }, { c: '#9D559C', cName: '' }, { c: '#C95C9D', cName: '' }, { c: '#DC75AB', cName: '' }, { c: '#EE7DAE', cName: '' }, { c: '#E6A5CA', cName: '' }, { c: '#EA94BE', cName: '' }, { c: '#D63F7D', cName: '' }, { c: '#C1374A', cName: '' }, { c: '#AB3255', cName: '' }, { c: '#A51263', cName: '' }, { c: '#7F285D', cName: ''}];
    $("#trace_show").click(function(){
        $("div.bgSelector").toggle(300, function() {
            if ($(this).html() == '') {
                $(this).sColor({
                    colors: bgColorSelectorColors,  // 必填，所有颜色 c:色号（必填） cName:颜色名称（可空）
                    colorsWidth: '50px',  // 必填，颜色的高度
                    colorsHeight: '31px',  // 必填，颜色的高度
                    curTop: '0', // 可选，颜色选择对象高偏移，默认0
                    curImg: 'templates/style/images/cur.png',  //必填，颜色选择对象图片路径
                    form: 'drag', // 可选，切换方式，drag或click，默认drag
                    keyEvent: true,  // 可选，开启键盘控制，默认true
                    prevColor: true, // 可选，开启切换页面后背景色是上一页面所选背景色，如不填则换页后背景色是defaultItem，默认false
                    defaultItem: ($.cookie('bgColorSelectorPosition') != null) ? $.cookie('bgColorSelectorPosition') : 32  // 可选，第几个颜色的索引作为初始颜色，默认第1个颜色
                });
            }
        });//切换显示
    });
	if ($.cookie('bgColorSelectorPosition') != null) {
        $('body').css('background-color', bgColorSelectorColors[$.cookie('bgColorSelectorPosition')].c);
    } else {
        $('body').css('background-color', bgColorSelectorColors[32].c);
    } 
});

/* 当前所在选项卡 */
var currTab = 'dashboard';
var firstOpen = [];
var maxHistoryLength = 5;
$(function(){
    /* 初始化标签页 */
    initHistory();
    initTopTab();
    /* 设置工作区 */
    setWorkspace();
    /* resize时重新设置工作区 */
    $(window).resize(setWorkspace);
	
	//后台导航
	var back_nav_list = $('.back_nav').clone().html();
	$("#back_btn").click(function(){
		layer.open({
			type: 1,
			area: ['650px', '300px'],
			title: '查看全部管理菜单',
			shade: 0.6,
			moveType: 1,
			shift: 1, 
			content: back_nav_list
		});    
	});
	
});
function initTopTab(){
    $.each(menu, function(k, v){
        var item = $('<li><a class="link" href="javascript:;" id="tab_' + k + '">' + v.text + '</a></li>');
        item.children('a').click(function(){var tabName = this.id.substr(4);if(tabName == currTab){return;}switchTab(tabName);openItem();});
        $('#nav').append(item);
    });

    /* 切换到默认选项卡 */
    switchTab(currTab);
    openItem(firstOpen[1], firstOpen[0]);
    $('#iframe_refresh').click(function(){
        $('#workspace').get(0).contentWindow.location.reload();
    });
    $('#clear_cache').click(function(){
        var url = 'index.php?act=clear_cache';
        $.getJSON(url, {}, function(data){
            parent.layer.alert(data.msg,{icon: 1});
        });
    });
}
function initHistory(){
    readHistory();
    $(window).unload(saveHistory);
}
function readHistory(){
    var h = $.getCookie('actionHistory');
    if(h != '' && h != 'undefined'){
        var arr = h.split(',').reverse();
        $.each(arr, function(){
            var tmp = this.split('-');
            addHistoryItem(tmp[0], tmp[1]);
        });
        if(arr.length){
            firstOpen = arr[arr.length - 1].split('-');
        }
    }
}
function saveHistory(){
    var h = '';
    $('#history dd').each(function(){
        h += $(this).find('a:first').attr('id') + ',';
    });
    var v = h.substr(0, (h.length - 1));
    $.setCookie('actionHistory', v);
}
function addHistoryItem(tab, item){
    var id = '#' + tab + '-' + item;
    if($(id).length == 1){
        /* 若存在提到最前 */
        var cln = $(id).parent().clone(true);
        $(id).parent().remove();
        $('#history dt').after(cln);

    }
    else{
        /* 不存在，则加入 */
        if(typeof(menu[tab]['children'][item]) == 'undefined'){
            return;
        }
        if($('#history dd').length == maxHistoryLength){
            $('#history dd:last').remove();
        }
        var lnk = $('<a href="javascript:;" id="' + tab + '-' + item + '"><i class="fa fa-star-o"></i>' + menu[tab]['children'][item]['text'] + '</a>');
        var close = $('<i class="fa fa-times close"></i>');
        lnk.click(function(){
            openItem(item, tab);
        });
        close.click(function(){
            $(this).parent().remove();
        });
        $('<dd></dd>').append(lnk).append(close).insertAfter($('#history dt'));
    }
}
function switchTab(tabName){
    currTab = tabName;
    pickTab();
    loadSubmenu();
}
function pickTab(){
    var id = '#tab_' + currTab;
    $('#nav').find('a').each(function(){
        $(this).removeClass('actived');
        $(this).addClass('link');
    });
    $(id).addClass('actived');
}
function loadSubmenu(){
    var m = menu[currTab];
    /* 子菜单标题 */
    $('#submenuTitle').text(m.subtext ? m.subtext : m.text);
    /* 删除所有现有子菜单 */
    $('#submenu').find('dd').remove();
    /* 将子菜单逐项添加到菜单中 */
    $.each(m.children, function(k, v){
        var p = v.parent ? v.parent : currTab;
        var item = $('<dd><a href="javascript:;" url="' + v.url + '" parent="' + p + '" id="item_' + k + '"><i class="fa fa-star-o"></i>' + v.text + '</a></dd>');
        item.children('a').click(function(){
            openItem(this.id.substr(5));
        });
        $('#submenu').append(item);
    });
}
function openItem(itemIndex, tab){
    if(typeof(itemIndex) == 'undefined')
    {
        var itemIndex = menu[currTab]['default'];
    }
    var id      = '#item_' + itemIndex;
    if(tab){
        var parent = tab;
    }else{
        var parent  = $(id).attr('parent');
    }
    /* 若不在当前选项卡内 */
    if(parent != currTab){
        /* 切换到指定选项卡 */
        switchTab(parent);
    }
    /* 高亮当前项 */
    $('#submenu').find('a').each(function(){
        $(this).removeClass('selected');
    });
    $(id).addClass('selected');

    /* 更新iframe的内容 */
    $('#workspace').show();
    $('#workspace').attr('src', $(id).attr('url'));

    /* 将该操作加入到历史访问当中 */
    addHistoryItem(currTab, itemIndex);
	layer.closeAll();
}
/* 设置工作区 */
function setWorkspace(){
    var wWidth = $(window).width();
    var wHeight = $(window).height();
    $('#workspace').width(wWidth - $('#left').width() - parseInt($('#left').css('margin-right')));
    $('#workspace').height(wHeight - $('#head').height());
}
