import { DateTime } from 'luxon';
import './style.scss';

function initCountdownTimer() {
    const timerContainer = $('.block-countdown-timer');
    if (timerContainer.length > 0) {
        if (!timerContainer.data('countdown')) {
            return;
        }

        // Move div to bottom of screen if pinned.
        const blockIsPinned = timerContainer.data('block-pinned');
        if (blockIsPinned) {
            $(timerContainer).insertAfter($('#wrapper-footer'));
        }
        // Get the date property from the div.
        const futureDate = timerContainer.data('countdown');
        const showSeconds = false;

        // Get the ended message property from the div.
        // let finishedMessage = timerContainer.data('ended-message');
        // if (typeof finishedMessage === 'undefined') {
        //     finishedMessage = 'The timer has ended';
        // }

        // Get the container containing the numbers.
        const timeContainer = $('.countdown_timer__times');

        // Create an alias for Datetime.
        // const DateTime = luxon.DateTime;
        const countDownDate = DateTime.fromISO(futureDate);
        const timer = setInterval(() => {
            const now = DateTime.now();
            const diff = countDownDate.diff(now, ['days', 'hours', 'minutes', 'seconds']).toObject();

            let distance = diff.days * 24 * 60 * 60
            + diff.hours * 60 * 60
            + diff.minutes * 60
            + diff.seconds;

            if (!showSeconds) {
                // Add 1 minute so that "minutes" doesn't show as '0' when the seconds value is 59.
                if (diff.seconds > 0 && diff.seconds < 60) {
                    diff.minutes += 1;
                    distance = diff.days * 24 * 60 * 60
                    + diff.hours * 60 * 60
                    + diff.minutes * 60
                    + diff.seconds;
                }
            }

            // Show the finished message.
            if (distance <= 0) {
                clearInterval(timer);
                // $(timeContainer).fadeTo(250, 0, () => {
                //     $(timeContainer).html('<h4>' + finishedMessage + '</h4>');
                // }).fadeTo(1000, 1);
                return;
            }

            // Fade the container in.
            $(timeContainer).fadeTo(250, 1);

            const days = Math.floor(distance / (24 * 60 * 60));
            const hours = Math.floor((distance % (24 * 60 * 60)) / 3600);
            const minutes = Math.floor((distance % 3600) / 60);
            const seconds = Math.floor(distance % 60);

            const dayText = (days > 1 || days === 0) ? 'Days' : 'Day';
            const hourText = (hours > 1 || hours === 0) ? 'Hours' : 'Hour';
            const minuteText = (minutes > 1 || minutes === 0) ? 'Minutes' : 'Minute';
            const secondText = (seconds > 1 || seconds === 0) ? 'Seconds' : 'Second';

            // Update divs.
            $('.timer__item--day').find('span.day').html(days);
            $('.timer__item--day').find('span.timer__title').html(dayText);

            $('.timer__item--hour').find('span.hour').html(hours);
            $('.timer__item--hour').find('span.timer__title').html(hourText);

            $('.timer__item--minute').find('span.minute').html(minutes);
            $('.timer__item--minute').find('span.timer__title').html(minuteText);

            if (showSeconds) {
                $('.timer__item--second').find('span.second').html(seconds);
                $('.timer__item--second').find('span.timer__title').html(secondText);
            }
        }, 1000);
    }
}

initCountdownTimer();
