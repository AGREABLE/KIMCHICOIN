function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

$(document).ready( function() {
    $(".ajaxform").submit(function(e)
    {
        if ( $(this).data('submit') != undefined && !eval( $(this).data('submit') ) ) {
            return false;
        }

        var postData = new FormData();
        $(this).find('input[type="file"]').each(function($i){
            postData.append( $(this).attr("name"), $(this)[0].files[0] );
        });
        $(this).find('input[type="checkbox"]').each(function($i){
            postData.append( $(this).attr("name"), ( $(this).is(':checked') ) ? $(this).val() : 0 );
        });
        var other_data = $(this).serializeArray();
        $.each(other_data,function(key,input){
            if ( !postData.has( input.name ) ) {
                if (input.value == "" & $('[name="' + input.name + '"]').data('is_ck') == 1)
                    postData.append(input.name, CKEDITOR.instances[input.name].getData());
                else
                    postData.append(input.name, input.value);
            }
        });
        var formURL = $(this).attr("action");

        $('body').addClass('loading-overlay-showing');
        $.ajax(
            {
                url : formURL,
                type: "POST",
                data : postData,
                processData: false,
                contentType: false,
                success:function(data, textStatus, jqXHR)
                {
                    var result = JSON.parse( data );
                    if ( result.error_code == 200 ) {
                        if ( result.error_msg != '' )
                            alert( result.error_msg );
                        if ( result.data.moveUrl != undefined )
                            window.location = result.data.moveUrl;
                        else
                            location.reload();
                    } else
                        alert( result.error_msg );
                    $('body').removeClass('loading-overlay-showing');
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    alert( '입력하신 정보를 다시 확인해주세요.' );
                    $('body').removeClass('loading-overlay-showing');
                }
            });
        e.preventDefault(); //STOP default action
        //e.unbind(); //unbind. to stop multiple form submit.
    });

    (function timeAgo(selector) {

        var templates = {
            prefix: "",
            suffix: " ago",
            seconds: "less than a minute",
            minute: "about a minute",
            minutes: "%d minutes",
            hour: "about an hour",
            hours: "about %d hours",
            day: "a day",
            days: "%d days",
            month: "about a month",
            months: "%d months",
            year: "about a year",
            years: "%d years"
        };

        var templates_kr = {
            prefix: "",
            suffix: " 전",
            seconds: "방금",
            minute: "1분",
            minutes: "%d분",
            hour: "1시간",
            hours: "%d시간",
            day: "하루",
            days: "%d일",
            month: "한달",
            months: "%d달",
            year: "1년",
            years: "%d년"
        };
        var template = function (t, n) {
            if ( getCookie( 'lang' ) == 'ko' )
                return templates_kr[t] && templates_kr[t].replace(/%d/i, Math.abs(Math.round(n)));
            else
                return templates[t] && templates[t].replace(/%d/i, Math.abs(Math.round(n)));
        };

        var timer = function (time) {
            if (!time) return;
            time = time.replace(/\.\d+/, ""); // remove milliseconds
            time = time.replace(/-/, "/").replace(/-/, "/");
            time = time.replace(/T/, " ").replace(/Z/, " UTC");
            time = time.replace(/([\+\-]\d\d)\:?(\d\d)/, " $1$2"); // -04:00 -> -0400
            time = new Date(time * 1000 || time);

            var now = new Date();
            var seconds = ((now.getTime() - time) * .001) >> 0;
            var minutes = seconds / 60;
            var hours = minutes / 60;
            var days = hours / 24;
            var years = days / 365;

            if ( getCookie( 'lang' ) == 'ko' )
                return templates_kr.prefix + (
                    seconds < 45 && template('seconds', seconds) || seconds < 90 && template('minute', 1) || minutes < 45 && template('minutes', minutes) || minutes < 90 && template('hour', 1) || hours < 24 && template('hours', hours) || hours < 42 && template('day', 1) || days < 30 && template('days', days) || days < 45 && template('month', 1) || days < 365 && template('months', days / 30) || years < 1.5 && template('year', 1) || template('years', years)) + templates_kr.suffix;
            else
                return templates.prefix + (
                    seconds < 45 && template('seconds', seconds) || seconds < 90 && template('minute', 1) || minutes < 45 && template('minutes', minutes) || minutes < 90 && template('hour', 1) || hours < 24 && template('hours', hours) || hours < 42 && template('day', 1) || days < 30 && template('days', days) || days < 45 && template('month', 1) || days < 365 && template('months', days / 30) || years < 1.5 && template('year', 1) || template('years', years)) + templates.suffix;
        };

        var elements = document.getElementsByClassName('timeago');
        for (var i in elements) {
            var $this = elements[i];
            if (typeof $this === 'object') {
                $this.innerHTML = timer($this.getAttribute('title') || $this.getAttribute('datetime'));
            }
        }
        // update time every minute
        setTimeout(timeAgo, 60000);

    })();
});

var makeSendForm = function( url, data ) {
    form = document.createElement("form"),
        node = document.createElement("input");

    form.action = url;
    form.method = 'POST';

    for ( k in data ) {
        node.name  = k;
        node.value = data[k];
        form.appendChild(node.cloneNode());
    }

    form.style.display = "none";
    document.body.appendChild(form);

    form.submit();
}