/*
 * Functions
 * Elkadrey - codesgit.com
 * 2014-05-14
 */
var matched, browser;

jQuery.uaMatch = function (ua) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec(ua) ||
            /(webkit)[ \/]([\w.]+)/.exec(ua) ||
            /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(ua) ||
            /(msie) ([\w.]+)/.exec(ua) ||
            ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(ua) ||
            [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch(navigator.userAgent);
browser = {};

if (matched.browser) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if (browser.chrome) {
    browser.webkit = true;
} else if (browser.webkit) {
    browser.safari = true;
}

jQuery.browser = browser;

function luhn_check(number)
{
//<![CDATA[

    // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
    var number = number.replace(/\D/g, '');

    // Set the string length and parity
    var number_length = number.length;
    var parity = number_length % 2;

    // Loop through each digit and do the maths
    var total = 0;
    for (i = 0; i < number_length; i++) {
        var digit = number.charAt(i);
        // Multiply alternate digits by two
        if (i % 2 == parity) {
            digit = digit * 2;
            // If the sum is two digits, add them together (in effect)
            if (digit > 9) {
                digit = digit - 9;
            }
        }
        // Total up the digits
        total = total + parseInt(digit);
    }

    // If the total mod 10 equals 0, the number is valid
    if (total % 10 == 0) {
        return true;
    } else {
        return false;
    }

//]]>
}

function string_to_int(number)
{
    var number = number.replace(/[^0-9]/g, '');
    return number;
}
function string_to_float(number)
{
    var number = number.replace(/[^0-9\-\.]/g, '');
    return number;
}

function string_to_phone(number)
{
    var number = number.replace(/[^0-9\-\+\/]/g, '');
    return number;
}

function ask(q)
{
    if (q)
    {
        if (!confirm(q))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}
function goto(url, param, newWindow)
{
    if(param) url += (len(url.split("?")) > 1 ? '&' : '?') + $.param(param);
    window.open(url, newWindow ? "_blank" : "_self");
}
function gotothispage(url)
{
    window.setTimeout('goto( "' + url + '");', 1000);
}

function ask_b(q, url)
{
    if (ask(q))
    {
        goto(url);
    }
    else
    {
        return false;
    }
}

function round(num, dec)
{
    var result = Math.round(parseFloat(num) * Math.pow(10, dec)) / Math.pow(10, dec);
    return result;
}


function gotoContent(element, obj)
{
    if (!obj)
        obj = {};
    if (jQuery(element).length == 0 || !jQuery(element).offset() || (obj.target && ($(obj.target).length == 0)))
    {
        if (obj.callBack) obj.callBack();
        return;
    }

    var top = jQuery(element).offset().top || 0;
    var left = jQuery(element).offset().left || 0;
    if (obj.top)
        top += obj.top;
    if (obj.left)
        left += obj.left;
    
    jQuery(obj.target || 'html, body').animate(
        {
            scrollTop: obj.freezeTop || top,
            scrollLeft: obj.freezeLeft || left
        }, "slow", null, function ()
    {
        if (obj.callBack) obj.callBack();
    });
}

function brwStester()
{
    return (document.compatMode && document.compatMode != "BackCompat") ? document.documentElement : document.body;
}

function addSlashes(str)
{
    return strReplace(['"', "'"], ['\"', "\'"], str);
}
function stripSlashes(str)
{
    return strReplace(['\"', "\'"], ['"', "'"], str);
}

function replaceQuotes(str)
{
    return strReplace(['"', "'"], ['``', "`"], str);
}

function uTime(milliSeconds)
{
    var today = new Date();    
    return milliSeconds ? today.getMilliseconds() : today.getTime();
}

function time(theUnixTime, format)
{

    var today = new Date();
    if (theUnixTime)
        today.setTime(theUnixTime * 1000);
//    if(today.getTime() >= day.getTime() && today.getTime() < (day.getTime() + (60*60*24*1000)))
//    {
    var hour = today.getUTCHours();
    var meridiem = (hour < 12) ? 'AM' : 'PM';

    var seconds = (today.getSeconds() < 10) ? '0' + today.getSeconds() : today.getSeconds();
    var minutes = (today.getMinutes() < 10) ? '0' + today.getMinutes() : today.getMinutes();
    var theHour = (hour < 12) ? hour : (hour - 12);
    var month = today.getMonth() + 1;
    var day = today.getDate();
    if (day < 10)
        day = '0' + day;
    if (month < 10)
        month = '0' + month;



    if (format)
    {
        var date = "";
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jal', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var arabicMonths = ['يناير', 'فبراير', 'مارس', 'إبريل', 'مايو', 'يونية', 'يولية', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
        for (var i = 0; i < format.length; i++)
        {
            var l = format.substr(i, 1);
            switch (l)
            {
                case 'd':
                    date += day;
                    break;
                case 'm':
                    date += month;
                    break;
                case 'M':
                    date += months[month - 1];
                    break;
                case 'r':
                    date += arabicMonths[month - 1];
                    break;
                case 'Y':
                    date += today.getFullYear();
                    break;
                case 'y':
                    date += today.getYear();
                    break;
                case 'h':
                    date += theHour;
                    break;
                case 'H':
                    date += hour;
                    break;
                case 'a':
                    date += meridiem.toLowerCase();
                    break;
                case 'A':
                    date += meridiem.toUpperCase();
                    break;
                case 'i':
                    date += minutes;
                    break;
                case 's':
                    date += seconds;
                    break;
                default:
                    date += l;
            }
        }
    }
    else
    {
        var date = {};
        date.time = theHour + ':' + minutes + meridiem;
        date.date = today.getFullYear() + '-' + month + '-' + day;
    }
    return date;
//    }
}

function unixTime(date)
{
    var today = new Date();
    if (date)
    {
        var timeData = date.split(" ");
        var dateData = timeData[0].split("-");

        today.setFullYear(dateData[0], (dateData[1] - 1), dateData[2]);
        if (timeData.length > 1)
        {
            var time = (timeData[1]).split(":");
            if (time.length == 3)
            {
                today.setHours(time[0]);
                today.setMinutes(time[1]);
                today.setSeconds(time[2]);
            }
        }
    }
    return Math.round(today.getTime() / 1000);
}

function uniqueId()
{
//    return (((1 + Math.random()) * 0x1000000) | 0).toString().substr(2, 9);
    return uTime()+'|'+uTime(true);
}
function uniqueChar()
{
    return Math.random().toString(36).substr(2, 9);
}

function stripTags(htmlData)
{
    return  String(htmlData).replace(/(<([^>]+)>)/ig, "");
}

function strURL(str)
{
    str = stripTags(str);
    str = str.replace(/\s/g, "_")
    return str.toLowerCase();
}

function setVal(cname, cvalue, exdays)
{
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";
}

function getVal(cname)
{
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1);
        if (c.indexOf(name) == 0)
            return c.substring(name.length, c.length);
    }
    return "";
}

function isSet(i)
{
    if (i != null && i && i != "undefined" && i != "" && i != undefined)
        return true;
}

function isArray(i)
{
    if (i && i != "undefined" && i != undefined)
        if (i instanceof Array)
            return true;
}

function isObject(i)
{
    if (i && i != "undefined" && i != undefined)
        if (i instanceof Object)
            return true;
}

function isString(i)
{
    if (i && i != "undefined" && i != undefined)
        if (typeof i == "string" || typeof i == "STRING")
            return true;
}
function isNumaric(i)
{
    return !i || isNaN(i) ? false : true;
}
function isFunction(functionToCheck)
{
    var getType = {};
    return functionToCheck && getType.toString.call(functionToCheck) === '[object Function]';
}
function getObjData(obj, space)
{
    if (!space)
        space = "";
    var res = "";
    for (var i in obj)
    {
        var o = obj[i];
        if (isObject(o) || isArray(o))
        {
            res += space + i + "=>\n" + space + "     {\n" + getObjData(o, space + "     ") + space + "     }\n";
        }
        else
            res += space + i + "=>" + o + "\n";
    }

    return res;
}


function findInArray(val, arr)
{
    return arr.indexOf(val);
}

function inArray(val, arr)
{
    if(isArray(val) && isArray(arr))
    {
        var status = false;
        
        for(var i in val)
        {            
            if(arr.indexOf(val[i]) > -1)
            {
                status = true;
                return true;
            }
        }
        
        return status;
    }
    else return isArray(arr) && arr.indexOf(val) > -1 ? true : false;
}

function inObject(val, obj)
{
    if(!isArray(obj) && !isObject(obj)) return false;
    for (var i in obj)
    {
        if (obj[i] == val)
        {
            return true;
        }
    }
    return false;
}

function isJsonText(contents)
{
    contents =  isString(contents) ? contents.trim() : "";
    var status = inArray(contents.substr(0, 1), ["{", "["]) && inArray(contents.substr(contents.length - 1, 1), ["}", "]"]);
    show(status, "status");
    return status;
}
function json(url, post, callback)
{
    jQuery.post(url, post, function (res)
    {
        if (isJsonText(res))
        {
            if (callback)
                callback(JSON.parse(res));
        }
        else
            return false;
    });
}
function escapeRegExp(string)
{
    return isString(string) ? string.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1") : string;
}

function explode(spliter, str)
{
    return str && isString(str) ? str.split(spliter) : [];
}
function implode(spliter, arr)
{    
    if(isArray(arr))
    {
        arr = arr.join(spliter);
    }
    else if(isObject(arr))
    {
        var newarr = '';
        $.each(arr, function(i, ii)
        {
            if(newarr != '') newarr += spliter;
            newarr += ii;
        });
        arr = newarr;
    }
     
    return arr;
}
function checkifIP(theText)
{
    if (theText.match(/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/i))
        return true;
    if (theText.match(/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.\*$/i))
        return true;
    if (theText.match(/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.\*$/i))
        return true;
    if (theText.match(/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.\*jQuery/i))
        return true;
    else
        return false;
}

function imageReader(srcName, fileData)
{
    if (srcName && fileData)
    {
        readData(fileData, function(result)
        {
            jQuery(srcName).removeAttr('data-src').attr('src', result);
        });
    }
}

function readData(fileData, callBack)
{
    var reader = new FileReader();
    var calledDone = false;
    reader.onload = function (e)
    {
        if(calledDone) return false;
        if(e.target.result)
        {
            calledDone = true;
            callBack(e.target.result);            
        }
    };
    reader.readAsDataURL(fileData);
}

function checkBrowser()
{
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0)      // If Internet Explorer, return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie))) < 10 ? false : true;
    else                 // If another browser, return 0
        return true;

    return false;
}

function repeat(format, limits, startFrom)
{
    var txt = "";
    if (!startFrom)
        startFrom = 1;
    for (var i = startFrom; i <= limits; i++)
    {
        txt += format;
    }
    return txt;
}

function esc(str)
{
    str = str.replace(/\+/g, '[||||]').replace(/&/g, '[|and|]');
    return str;
}
function clearSelection()
{
    if (document.selection && document.selection.empty) {
        document.selection.empty();
    } else if (window.getSelection) {
        var sel = window.getSelection();
        sel.removeAllRanges();
    }
}

function rand(from, to)
{
    return Math.floor(Math.random(from) * to);
}

function isSet(str)
{
    return  str !== undefined && str !== 'undefined' && str !== 'NaN' && str !== NaN ? true : false;
}
function isEmpty(str)
{
    return  isSet(str) || (isString(str) && str === "") || (isNumaric(str) && str === 0) ? true : false;
}
function params(url, withURL)
{
    if (!isString(url))
        return null;
    var parametars = {};
    var urls = url.split("?");
    if (urls[1]) 
    {
        parametars = JSON.parse('{"' + decodeURI(urls[1]).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g,'":"').replace(/=/g,'":"').replace(/\[/g,'_').replace(/\]/g,'') + '"}');
        
    }
    return withURL ? {url: urls[0], params: parametars} : parametars;
}




function test(text, append)
{
    if ($("#testingArea").length === 0)
        $("body").append('<div id="testingArea" style="position: fixed;bottom: 0px;left: 0px;background: #fff;padding: 20px;z-index: 500000;"></div>');
    if (!append)
        $("#testingArea").html(text);
    else
        $("#testingArea").append(text + '<Br>');
}

function catchHashTag(url, activeListener)
{
    var tag = window.location.hash;
    if (tag !== "" && tag !== "#")
    {
        tag = tag.substr(1);
        url = url.replace('{tag}', tag);
        goto(url);
    }

    if (activeListener === true)
    {
        $(window).on('hashchange', function ()
        {
            catchHashTag(url);
        });
    }
}

function trans(key, arr)
{
    return settings.Translate(key, arr);
}

function makeVar(str)
{
    return (strReplace([' ', '_', "'", '"', "?", "#", "@", "$", "!", "~", "%", "&", "^", "*", "(", ")", "[", "]", "{", "}", "=", "+", "/", "\\", ";", ","], "-", str)).toLowerCase();
}

function empty(val)
{
    return !val || val == "" || val == "undefined" || val == "0" || val == NaN;
}

function emptyGroup(obj, names)
{
    if(isArray(names) && (isObject(obj) || isArray(obj)))
    {
        var status = false;
        $.each(names, function(i, name)
        {
            if(empty(obj[name])) status = true;
        });
        return status;
    }
    else return true;
}

function emptySerial(obj)
{
    if((isObject(obj) || isArray(obj)))
    {
        var status = false;
        $.each(obj, function(i, name)
        {
            if(empty(obj[name])) status = true;
        });
        return status;
    }
    else return true;
}

function createEffect(that)
{
    that.removeClass('comeFromLeft').removeClass('comeFromRight').removeClass('centerFade');
    if (that.hasClass('comeFromRight2') || that.hasClass('comeFromLeft2'))
        window.setTimeout(function ()
        {
            that.removeClass('comeFromLeft2').removeClass('comeFromRight2');
        }, 200);
}

function runEffects()
{
    var startup = 350;
    $(".hidingFromView").each(function ()
    {
        var that = $(this);
        if (that.hasClass('rightNow'))
            createEffect(that);
        else if ($(document).scrollTop() > that.offset().top - startup)
        {
            createEffect(that);
        }
    });
}

function activeButton(me)
{
    $(me).each(function ()
    {
        if (!$(this).hasClass('activatedbuttonAdded'))
        {
            $(this).addClass('activatedbuttonAdded')
            var target = $(this).attr('target');
            var deactive = $(this).attr('deactive');
            var active = $(this).attr('active');
            $(this).click(function ()
            {
                if ($(this).hasClass('btn-success'))
                    $(this).removeClass('btn-success').addClass('btn-danger').val(deactive);
                else
                    $(this).addClass('btn-success').removeClass('btn-danger').val(active);
                $(target).val($(this).hasClass('btn-success') ? 1 : 0);
                $(this).blur();
                var call = $(this).attr('callback');
                if (call)
                    eval(call);
            });

            if ($(target).val() === "1")
                $(this).addClass('btn-success').removeClass('btn-danger').val(active);
            else
                $(this).removeClass('btn-success').addClass('btn-danger').val(deactive);
        }
    });
}

function outKeys(keyCode, withPoint)
{
    switch (keyCode)
    {
        case 110:
            if (!withPoint)
                return false;
        case 8:
        case 13:
        case 37:
        case 38:
        case 35:
        case 36:
        case 33:
        case 34:
        case 39:
        case 40:
        case 46:
        case 116:
        case 9:
        case 107:
        case 109:
            return true;
            break;
        default:
            return false;
    }
}

function len(obj)
{
    if(empty(obj)) return 0;
    if (isObject(obj))
        return Object.keys(obj).length;
    else 
    {
        if(isNumaric(obj)) obj = obj.toString();
        return (obj).length || 0;
    }
}

function lenEach(obj, sp)
{    
    if(!isArray(obj) && !isObject(obj)) return 0;
    
    var count = 0;
    $.each(obj, function(i, rs)
    {
        if(sp && (isObject(rs) || isArray(rs)))
        {
            
            var status = true;
            $.each(sp, function(k, v)
            {
                if((isArray(v) && inArray(rs[k], v)) || rs[k] != v) status = false;
            });
            
            if(status) count++;
        }
        else if(!sp) count++;
    });
    
    return count;
}

function lenNotEmpty(obj)
{
    var l = 0;
    if(isArray(obj) || isObject(obj))
    {
        for(var i in obj)
        {
            if(!empty(obj[i])) l++;
        }
        
        return l;
    }
    else return 0;
}

function spKeys(selector, withPoint)
{
    $(document).on("keydown", selector, function (e)
    {

        if (withPoint && withPoint !== true && withPoint > 0 && e.keyCode == 110 && (($(this).val()).split(".")).length > 1)
            return false;
        else
        {
            var pointer = $(this).prop("selectionStart");
            var key = e.keyCode;
            var isNumaric = (key <= 105 && key >= 96) || (key <= 57 && key >= 48);
            var result = outKeys(key, withPoint) || isNumaric ? true : false;
            var theValue = $(this).val();

            if (withPoint && result && !empty(theValue))
            {
                var val = theValue.split(".");
                var len = (val[1] || "").length;
                if (withPoint === true && key == 110 && val.length >= 2)
                    result = false;
                else if (withPoint !== true && len >= withPoint && pointer > (val[0]).length && !outKeys(key))
                    result = false;
                else if (withPoint !== true && key == 110 && pointer < theValue.length - withPoint)
                    result = false;
            }
            else if (empty(theValue) && key == 110 && result)
            {
                $(this).val(0);
            }
            return result;
        }
    });
}

function echo(str, func, css)
{
    if(!func) func = 'log';
    if(css)
    {
        str = '%c ' + str;
    }
    console[func](str, css || "");
}

function show(str, title, func)
{
    if(!title) title = '***********************************';
    echo(title, null, 'color: red;font-size: 16px');
    return echo(str, func);
}

function activeToolTips()
{
    $(".tooltips").not("toolActivated").each(function ()
    {
        var placement = $(this).attr('target') || 'top';
        $(this).addClass('toolActivated').tooltip({placement: placement});
    });
}



function moneyFormat(value, limit, thousandSpliter)
{
    return parseFloat(value);
    if (empty(limit) && limit !== 0)
        limit = 2;

    value = (value + "").split(".");

    if (empty(value[1]))
        value[1] = "";
    value[1] += repeat("0", limit - len(value[1]));
    value[1] = (value[1]).substr(0, limit);

    if (thousandSpliter)
        value[0] = (value[0]).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

    return value[0] + '.' + value[1];
}

function parseStr(obj)
{
    return obj && !isString(obj) ? obj.toString() : obj;
}

function fetch(obj, space)
{
    var str = '';
    if (!space)
        space = '';
    if (isArray(obj) || isObject(obj))
    {
        for (var i in obj)
        {
            str += space + (isArray(obj) ? '[' : '{');
            str += i + ' => ' + fetch(obj[i], space + "\t");
            str += space + (isArray(obj) ? ']' : '}') + "\n";
        }
    }
    else
        str = obj;
    return str;
}

function param(url)
{
    var search = url.split("?");
    if (search.length > 1)
        url = search[1];
    return JSON.parse('{"' + decodeURI(url).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g, '":"') + '"}');
}

function isInt(n) {
    return Number(n) === n && n % 1 === 0;
}

function isFloat(n) {
    return n === Number(n) && n % 1 !== 0;
}


function include(filePath, type)
{
    switch(type)
    {
        default:            
            return $("head").append('<' + 'script type="text/javascript" src="' + filePath + '"></script>');
            break;
        case 'css':
            $("head").append('<' + 'link href="' + filePath + '?_=' + uTime() + '" rel="stylesheet" type="text/css" />');
            break;
    }            
}

function cs2(ele) {
    ele.select2()
    setTimeout(function () {
        ele.trigger("change")
    }, 100)

}

function isDate(date, format)
{
    return moment(date, format || 'YYYY-MM-DD', true).isValid();
}

var toObject = function(Array) 
{
    var obj = {};
    $.each(Array, function(i, v)
    {
        obj[i] = v;
    });
    return obj;
}
,toArray = function(Array, withKeys) 
{
    if(!isObject(Array) && !isArray(Array)) return [];
    var obj = [];    
    $.each(Array, function(i, v)
    {
        if(!withKeys) obj.push(v);
        else obj.push([i, v]);
    });
    return obj;
}
,
clone = function(obj) 
{
    return jQuery.extend(true, {}, obj);
},
isEmail = function(text)
{
    var emailTest = new RegExp(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/);
    
    return emailTest.test(text);
};

function addSlashes(str)
{
    str = str.replace(/'/g, "\\'");
    return str.replace(/"/g, '\\"');
}
function stripSlashes(str)
{
    str = str.replace(/\\'/g, "'");
    return str.replace(/\\"/g, '"');
}

function getIndex(obj, getKey, index)
{
    if(!index) index = 1;
    var ind = 0;
    var $val = null;
    if(isArray(obj) || isObject(obj))
    {
        for(var i in obj)
        {
            ind++;
            if(ind == index)
            {
                $val = getKey ? i : obj[i];
                return $val;
            }
        }
        return $val;
    }
    else obj;
}

function getKeyList(obj)
{
    var arr = [];
    if(isArray(obj) || isObject(obj))
    {
        for(var key in obj)
        {
            arr.push(key);
        }
    }
    
    return arr;
}
function merge(obj1, obj2, overwrite)
{
    if(!overwrite) 
    {
        var newObj = clone(obj1);
    }
    if((isArray(obj1) || isObject(obj1)) && (isArray(obj2) || isObject(obj2)))
    {
        $.each(obj2, function(key, value)
        {
            if(overwrite) obj1[key] = value;
            else newObj[key] = value;
        });
    }
    
    return overwrite ? obj1 : newObj;
}

function firstOne(obj)
{
    if(!isObject(obj) && !isArray(obj)) return null;   
    for(var i in obj)
    {
        return obj[i];
        break;
    }
}
function strReplace(oldStr, newStr, str)
{
    if (isArray(oldStr))
    {
        for (var i in oldStr)
        {
            var rpl = oldStr[i];
            var patt = new RegExp(escapeRegExp(rpl), 'g');
            str = str.replace(patt, (isArray(newStr) ? newStr[i] : newStr));
        }
        return str;
    }
    else if (isString(str))
    {
        var patt = new RegExp(oldStr, 'g');
        return str.replace(patt, newStr);
    }
    else
        return "";
}

function end(arr)
{
    if(isArray(arr)) return arr[len(arr) - 1] || null;
    else return null;
}

function trueObjToArray(obj, reverse)
{
    var arr = {};
    var reverseArr = {};
    if(len(obj) > 0 && (isArray(obj) || isObject(obj)))
    {
        $.each(obj, function(val, status)
        {
            if(status && val != 'null' && !reverse) arr[val] = val;
            else if(reverse) reverseArr[status] = true;
        });
    }
    return reverse ? reverseArr : arr;
}
function trueObjToStr(obj, split)
{
    var str = '';
    if(!split) split = ',';
    if(len(obj) > 0 && (isArray(obj) || isObject(obj)))
    {
        $.each(obj, function(val, status)
        {
            if(status && val != 'null') 
            {
                if(str != '') str += split;
                str += val;
            }
        });
    }
    return str;
}

function isValidMail(email)
{
    var emailTest = new RegExp(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,6})$/);
    return email && emailTest.test(email);
}

function backwardParses(text)
{
    var str = "";
    if(isString(text))
    {
        text = text.split(" ");
        for(var i = text.length;i >= 0;i--)
        {
            var t = text[i];
            if(t)
            {
                if(str != "") str += " ";
                str += t;
            }
        }
    }
    
    return str;
}
function popup(url, windowName, options)
{
    if(!options) options = {};
    var newwindow = window.open(url, windowName,'height=' + (options.height || 300) + ',width=' + (options.width || 500));
    if (window.focus) {newwindow.focus()}
}
spKeys(".numaric_only");
spKeys(".float_only", true);
spKeys(".money_only", 2); 

function dataURItoBlob(dataURI, type) 
{
  // convert base64 to raw binary data held in a string
  // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
  var byteString = atob(dataURI.split(',')[1]);

  // separate out the mime component
  var mimeString = type || (dataURI.split(',')[0].split(':')[1].split(';')[0]);

  // write the bytes of the string to an ArrayBuffer
  var ab = new ArrayBuffer(byteString.length);

  // create a view into the buffer
  var ia = new Uint8Array(ab);

  // set the bytes of the buffer to the correct values
  for (var i = 0; i < byteString.length; i++) {
      ia[i] = byteString.charCodeAt(i);
  }

  // write the ArrayBuffer to a blob, and you're done
  var blob = new Blob([ab], {type: mimeString});
  return blob;

}