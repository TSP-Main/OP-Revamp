document.addEventListener('DOMContentLoaded', function () {
    var progressBar = document.getElementById("chatbot-progressbar");
    var progressBarValue = document.getElementById("progressbarval");
    var progressBarPercent = document.getElementById("chatbot-progressbar__value");

    var percentagewidth = 0;

    var totalSteps = 19; // Total number of steps
    var currentStep = 1; // Initialize current step
    var proceedBtn = document.getElementById("proceedBtn");
    var proceedBtn_1 = document.getElementById("proceedBtn_1");
    var proceedBtn_2 = document.getElementById("proceedBtn_2");
    var proceedBtn_3 = document.getElementById("proceedBtn_3");
    var proceedBtn_5 = document.getElementById("proceedBtn_5");
    var proceedBtn_6 = document.getElementById("proceedBtn_6");
    var proceedBtn_7 = document.getElementById("proceedBtn_7");
    var proceedBtn_8 = document.getElementById("proceedBtn_8");
    var proceedBtn_9 = document.getElementById("proceedBtn_9");
    var proceedBtn_10 = document.getElementById("proceedBtn_10");
    var proceedBtn_11 = document.getElementById("proceedBtn_11");
    var proceedBtn_12 = document.getElementById("proceedBtn_12");
    var proceedBtn_13 = document.getElementById("proceedBtn_13");
    var proceedBtn_14 = document.getElementById("proceedBtn_14");
    var proceedBtn_15 = document.getElementById("proceedBtn_15");
    var proceedBtn_16 = document.getElementById("proceedBtn_16");
    var proceedBtn_17 = document.getElementById("proceedBtn_17");
    var proceedBtn_18 = document.getElementById("proceedBtn_18");
    var proceedBtn_19 = document.getElementById("proceedBtn_19");
    var proceedBtn_20 = document.getElementById("proceedBtn_20");
    var proceedBtn_21 = document.getElementById("proceedBtn_21");
    var proceedBtn_22 = document.getElementById("proceedBtn_22");
    var proceedBtn_23 = document.getElementById("proceedBtn_23");
    var proceedBtn_24 = document.getElementById("proceedBtn_24");
    var proceedBtn_25 = document.getElementById("proceedBtn_25");
    var proceedBtn_26 = document.getElementById("proceedBtn_26");
    var proceedBtn_27 = document.getElementById("proceedBtn_27");
    var proceedBtn_28 = document.getElementById("proceedBtn_28");
    var proceedBtn_29 = document.getElementById("proceedBtn_29");
    var proceedBtn_30 = document.getElementById("proceedBtn_30");
    var proceedBtn_31 = document.getElementById("proceedBtn_31");
    var proceedBtn_32 = document.getElementById("proceedBtn_32");
    var proceedBtn_33 = document.getElementById("proceedBtn_33");
    var proceedBtn_34 = document.getElementById("proceedBtn_34");
    var proceedBtn_35 = document.getElementById("proceedBtn_35");
    var proceedBtn_36 = document.getElementById("proceedBtn_36");
    var proceedBtn_37 = document.getElementById("proceedBtn_37");
    var proceedBtn_38 = document.getElementById("proceedBtn_38");

    var previousBtn = document.getElementById("previousBtn");
    var previousBtn2 = document.getElementById("previousBtn_2");
    var previousBtn3 = document.getElementById("previousBtn_3");
    var previousBtn4 = document.getElementById("previousBtn_4");
    var previousBtn5 = document.getElementById("previousBtn_5");
    var previousBtn6 = document.getElementById("previousBtn_6");
    var previousBtn7 = document.getElementById("previousBtn_7");
    var previousBtn8 = document.getElementById("previousBtn_8");
    var previousBtn9 = document.getElementById("previousBtn_9");
    var previousBtn10 = document.getElementById("previousBtn_10");
    var previousBtn11 = document.getElementById("previousBtn_11");
    var previousBtn12 = document.getElementById("previousBtn_12");
    var previousBtn13 = document.getElementById("previousBtn_13");
    var previousBtn14 = document.getElementById("previousBtn_14");
    var previousBtn15 = document.getElementById("previousBtn_15");
    var previousBtn16 = document.getElementById("previousBtn_16");
    var previousBtn17 = document.getElementById("previousBtn_17");
    var previousBtn18 = document.getElementById("previousBtn_18");
    var previousBtn19 = document.getElementById("previousBtn_19");
    var previousBtn20 = document.getElementById("previousBtn_20");
    var previousBtn21 = document.getElementById("previousBtn_21");
    var previousBtn22 = document.getElementById("previousBtn_22");
    var previousBtn23 = document.getElementById("previousBtn_23");
    var previousBtn24 = document.getElementById("previousBtn_24");
    var previousBtn25 = document.getElementById("previousBtn_25");
    var previousBtn26 = document.getElementById("previousBtn_26");
    var previousBtn27 = document.getElementById("previousBtn_27");
    var previousBtn28 = document.getElementById("previousBtn_28");
    var previousBtn29 = document.getElementById("previousBtn_29");
    var previousBtn30 = document.getElementById("previousBtn_30");
    var previousBtn31 = document.getElementById("previousBtn_31");
    var previousBtn32 = document.getElementById("previousBtn_32");
    var previousBtn33 = document.getElementById("previousBtn_33");
    var previousBtn34 = document.getElementById("previousBtn_34");
    var previousBtn35 = document.getElementById("previousBtn_35");
    var previousBtn36 = document.getElementById("previousBtn_36");
    var previousBtn37 = document.getElementById("previousBtn_37");
    var previousBtn38 = document.getElementById("previousBtn_38");
    var previousBtn39 = document.getElementById("previousBtn_39");
    var previousBtn40 = document.getElementById("previousBtn_40");

    var item1 = document.getElementById("item_1");
    var item2 = document.getElementById("item_2");
    var item3 = document.getElementById("item_3");
    var item4 = document.getElementById("item_4");
    var item5 = document.getElementById("item_5");
    var item6 = document.getElementById("item_6");
    var item7 = document.getElementById("item_7");
    var item8 = document.getElementById("item_8");
    var item9 = document.getElementById("item_9");
    var item10 = document.getElementById("item_10");
    var item11 = document.getElementById("item_11");
    var item12 = document.getElementById("item_12");
    var item13 = document.getElementById("item_13");
    var item14 = document.getElementById("item_14");
    var item15 = document.getElementById("item_15");
    var item16 = document.getElementById("item_16");
    var item17 = document.getElementById("item_17");
    var item18 = document.getElementById("item_18");
    var item19 = document.getElementById("item_19");
    var item20 = document.getElementById("item_20");
    var item21 = document.getElementById("item_21");
    var item22 = document.getElementById("item_22");
    var item23 = document.getElementById("item_23");
    var item24 = document.getElementById("item_24");
    var item25 = document.getElementById("item_25");
    var item26 = document.getElementById("item_26");
    var item27 = document.getElementById("item_27");
    var item28 = document.getElementById("item_28");
    var item29 = document.getElementById("item_29");
    var item30 = document.getElementById("item_30");
    var item31 = document.getElementById("item_31");
    var item32 = document.getElementById("item_32");
    var item33 = document.getElementById("item_33");
    var item34 = document.getElementById("item_34");
    var item35 = document.getElementById("item_35");
    var item36 = document.getElementById("item_36");
    var item37 = document.getElementById("item_37");
    var item38 = document.getElementById("item_38");
    var item39 = document.getElementById("item_39");
    var item40 = document.getElementById("item_40");
    var item = document.getElementById("item");

    var maleRadio = document.getElementById("html");
    var femaleRadio = document.getElementById("css");

    var noRadio = document.getElementById("noRadio");
    var yesRadio = document.getElementById("yesRadio");

    var no1 = document.getElementById("no1");
    var yes1 = document.getElementById("yes1");

    var no2 = document.getElementById("no2");
    var yes2 = document.getElementById("yes2");

    var no3 = document.getElementById("no3");
    var yes3 = document.getElementById("yes3");

    var no4 = document.getElementById("no4");
    var yes4 = document.getElementById("yes4");

    var no5 = document.getElementById("no5");
    var yes5 = document.getElementById("yes5");

    var no6 = document.getElementById("no6");
    var yes6 = document.getElementById("yes6");

    var no = document.getElementById("no");
    var yes = document.getElementById("yes");
    var not = document.getElementById("not");

    var unhappy = document.getElementById("unhappy");
    var neutral = document.getElementById("neutral");
    var happy = document.getElementById("happy");

    var general = document.getElementById("general");
    var Pre = document.getElementById("Pre");
    var PCOS = document.getElementById("PCOS");
    var Surgery = document.getElementById("Surgery");
    var Post = document.getElementById("Post");
    var Other = document.getElementById("Other");

    var medical = document.getElementById("medical");
    var Diabetes = document.getElementById("Diabetes");
    var Pancreatitis = document.getElementById("Pancreatitis");
    var Inflamed = document.getElementById("Inflamed");
    var Heart = document.getElementById("Heart");
    var Ketoacidosis = document.getElementById("Ketoacidosis");
    var Inflammatory = document.getElementById("Inflammatory");
    var Personal = document.getElementById("Personal");
    var Hormone = document.getElementById("Hormone");
    var Other2 = document.getElementById("Other");

    var I = document.getElementById("I");
    var My = document.getElementById("My");
    var weight = document.getElementById("weight");
    var gets = document.getElementById("gets");
    var depressed = document.getElementById("depressed");
    var exercise = document.getElementById("exercise");
    var surgery = document.getElementById("surgery");
    var explain = document.getElementById("explain");

    var normal = document.getElementById("normal");
    var high = document.getElementById("high");
    var low = document.getElementById("low");

    var yesreading = document.getElementById("yesreading");
    var yesnotreading = document.getElementById("yesnotreading");
    var noreading = document.getElementById("noreading");

    var below = document.getElementById("below");
    var above = document.getElementById("above");

    var diagnosed = document.getElementById("diagnosed");
    var depression = document.getElementById("depression");
    var diagnosis = document.getElementById("diagnosis");

    var Smoke = document.getElementById("Smoke");
    var occasionally = document.getElementById("occasionally");
    var regularly = document.getElementById("regularly");

    var alcohol = document.getElementById("alcohol");
    var drink = document.getElementById("drink");
    var daily = document.getElementById("daily");

    var takeaways = document.getElementById("takeaways");
    var takeaway = document.getElementById("takeaway");
    var week = document.getElementById("week");

    var unhealthy = document.getElementById("unhealthy");
    var snacks = document.getElementById("snacks");
    var eat = document.getElementById("eat");

    var mins = document.getElementById("mins");
    var more = document.getElementById("more");
    var moderate = document.getElementById("moderate");

    var a = document.getElementById("a");
    var b = document.getElementById("b");
    var c = document.getElementById("c");

    var no7 = document.getElementById("no7");
    var yes7 = document.getElementById("yes7");

    var no8 = document.getElementById("no8");
    var yes8 = document.getElementById("yes8");

    var no9 = document.getElementById("no9");
    var yes9 = document.getElementById("yes9");

    var Liraglutide = document.getElementById("Liraglutide");
    var Mysimba = document.getElementById("Mysimba");
    var Orlistat = document.getElementById("Orlistat");
    var Semaglutide = document.getElementById("Semaglutide");
    var management = document.getElementById("management");

    function updateProgressBar() {
        var percent = (currentStep / totalSteps) * 100;
        percent = Math.round(percent);
        progressBar.value = percent;
        progressBarValue.innerText = percent + "%";
        percentagewidth = percent + "%";
        progressBarPercent.style.width = percentagewidth;
    }

    updateProgressBar();

    previousBtn.addEventListener('click', function () {
        if (currentStep > 1) {
            currentStep--;
            showPreviousItem();
            updateProgressBar();
        }
    });

    previousBtn.addEventListener('click', function () {
        if (currentStep > 1) {
            currentStep--;
            showPreviousItem();
            updateProgressBar();
        }
    });

    proceedBtn.addEventListener('click', function () {
        if (maleRadio.checked) {
            item.style.display = 'none';
            item1.style.display = 'block';
        } else if (femaleRadio.checked) {
            item.style.display = 'none';
            item5.style.display = 'block';
        }
    });
    proceedBtn_1.addEventListener('click', function () {
        if (general.checked) {
            item1.style.display = 'none';
            item2.style.display = 'block';
        } else if (Pre.checked) {
            item1.style.display = 'none';
            item2.style.display = 'block';
        } else if (PCOS.checked) {
            item1.style.display = 'none';
            item2.style.display = 'block';
        } else if (Surgery.checked) {
            item1.style.display = 'none';
            item2.style.display = 'block';
        } else if (Post.checked) {
            item1.style.display = 'none';
            item2.style.display = 'block';
        } else if (Other.checked) {
            item1.style.display = 'none';
            item2.style.display = 'block';
        }
    });
    proceedBtn_2.addEventListener('click', function () {
        if (unhappy.checked) {
            item2.style.display = 'none';
            item3.style.display = 'block';
        } else if (neutral.checked) {
            item2.style.display = 'none';
            item3.style.display = 'block';
        } else if (happy.checked) {
            item2.style.display = 'none';
            item3.style.display = 'block';
        }
    });

    proceedBtn_3.addEventListener('click', function () {
        if (noRadio.checked) {
            item3.style.display = 'none';
            item4.style.display = 'block';
        } else if (yesRadio.checked) {
            item3.style.display = 'none';
            item6.style.display = 'block';
        }
    });

    proceedBtn_5.addEventListener('click', function () {
        if (no.checked) {
            item4.style.display = 'none';
            item9.style.display = 'block';

        } else if (yes.checked) {
            item4.style.display = 'none';
            item7.style.display = 'block';

        }
        else if (not.checked) {
            item4.style.display = 'none';
            item9.style.display = 'block';
        }
    });


    proceedBtn_7.addEventListener('click', () => {
        item8.style.display = 'none';
        item9.style.display = 'block';
    });

    proceedBtn_12.addEventListener('click', () => {
        item13.style.display = 'none';
        item9.style.display = 'block';
    });


// done
    proceedBtn_6.addEventListener('click', function () {
        if (normal.checked) {
            item7.style.display = 'none';
            item9.style.display = 'block';

        } else if (high.checked) {
            item7.style.display = 'none';
            item13.style.display = 'block';

        }
        else if (low.checked) {
            item7.style.display = 'none';
            item9.style.display = 'block';
        }

    });

    proceedBtn_8.addEventListener('click', function () {
        if (yesreading.checked) {
            item9.style.display = 'none';
            item10.style.display = 'block';

        } else if (yesnotreading.checked) {
            item9.style.display = 'none';
            item11.style.display = 'block';

        }
        else if (noreading.checked) {
            item9.style.display = 'none';
            item11.style.display = 'block';
        }
    });

    proceedBtn_9.addEventListener('click', function () {
        if (below.checked) {
            item10.style.display = 'none';
            item11.style.display = 'block';
        } else if (above.checked) {
            item10.style.display = 'none';
            item11.style.display = 'block';
        }
    });

    proceedBtn_10.addEventListener('click', function () {
        if (medical.checked) {
            item11.style.display = 'none';
            item12.style.display = 'block';
        } else if (Diabetes.checked) {
            item11.style.display = 'none';
            item14.style.display = 'block';
        } else if (Pancreatitis.checked) {
            item11.style.display = 'none';
            item14.style.display = 'block';
        } else if (Inflamed.checked) {
            item11.style.display = 'none';
            item14.style.display = 'block';
        } else if (Heart.checked) {
            item11.style.display = 'none';
            item14.style.display = 'block';
        } else if (Ketoacidosis.checked) {
            item11.style.display = 'none';
            item14.style.display = 'block';
        } else if (Inflammatory.checked) {
            item11.style.display = 'none';
            item14.style.display = 'block';
        } else if (Personal.checked) {
            item11.style.display = 'none';
            item14.style.display = 'block';
        } else if (Hormone.checked) {
            item11.style.display = 'none';
            item14.style.display = 'block';
        } else if (Other2.checked) {
            item11.style.display = 'none';
            item14.style.display = 'block';
        }
    });

    proceedBtn_11.addEventListener('click', function () {
        if (no1.checked) {
            item12.style.display = 'none';
            item15.style.display = 'block';
        } else if (yes1.checked) {
            item12.style.display = 'none';
            item18.style.display = 'block';
        }
    });

    proceedBtn_13.addEventListener('click', () => {
        item6.style.display = 'none';
        item4.style.display = 'block';
    });

    proceedBtn_14.addEventListener('click', () => {
        item14.style.display = 'none';
        item11.style.display = 'block';
    });

    proceedBtn_15.addEventListener('click', function () {
        if (no2.checked) {
            item15.style.display = 'none';
            item16.style.display = 'block';
        } else if (yes2.checked) {
            item15.style.display = 'none';
            item17.style.display = 'block';
        }
    });

    proceedBtn_17.addEventListener('click', function () {
        if (no4.checked) {
            // item15.style.display = 'none';
            // item16.style.display = 'block';
        } else if (yes4.checked) {
            item17.style.display = 'none';
            item16.style.display = 'block';
        }
    });

    proceedBtn_16.addEventListener('click', () => {
        item18.style.display = 'none';
        item15.style.display = 'block';
    });

    proceedBtn_18.addEventListener('click', function () {
        if (no5.checked) {
            item19.style.display = 'none';
            item20.style.display = 'block';
        } else if (yes5.checked) {
            item19.style.display = 'none';
            item21.style.display = 'block';
        }
    });

    proceedBtn_19.addEventListener('click', function () {
        if (no3.checked) {
            item16.style.display = 'none';
            item19.style.display = 'block';
        } else if (yes3.checked) {
            // item15.style.display = 'none';
            // item17.style.display = 'block';
        }
    });

    proceedBtn_20.addEventListener('click', () => {
        item21.style.display = 'none';
        item20.style.display = 'block';
    });

    proceedBtn_21.addEventListener('click', function () {
        if (diagnosed.checked) {
            item20.style.display = 'none';
            item22.style.display = 'block';

        } else if (depression.checked) {
            item20.style.display = 'none';
            item23.style.display = 'block';

        }
        else if (diagnosis.checked) {
            item20.style.display = 'none';
            item23.style.display = 'block';
        }
    });

    proceedBtn_22.addEventListener('click', () => {
        item23.style.display = 'none';
        item22.style.display = 'block';
    });

    proceedBtn_23.addEventListener('click', function () {
        if (no6.checked) {
            item22.style.display = 'none';
            item24.style.display = 'block';
        } else if (yes6.checked) {
            item22.style.display = 'none';
            item25.style.display = 'block';
        }
    });

    proceedBtn_24.addEventListener('click', () => {
        item25.style.display = 'none';
        item24.style.display = 'block';
    });

    proceedBtn_25.addEventListener('click', function () {
        if (I.checked) {
            item24.style.display = 'none';
            item26.style.display = 'block';
        } else if (My.checked) {
            item24.style.display = 'none';
            item26.style.display = 'block';
        } else if (weight.checked) {
            item24.style.display = 'none';
            item26.style.display = 'block';
        } else if (gets.checked) {
            item24.style.display = 'none';
            item26.style.display = 'block';
        } else if (depressed.checked) {
            item24.style.display = 'none';
            item26.style.display = 'block';
        } else if (exercise.checked) {
            item24.style.display = 'none';
            item26.style.display = 'block';
        } else if (surgery.checked) {
            item24.style.display = 'none';
            item26.style.display = 'block';
        } else if (explain.checked) {
            item24.style.display = 'none';
            item27.style.display = 'block';
        }
    });

    proceedBtn_26.addEventListener('click', () => {
        item27.style.display = 'none';
        item26.style.display = 'block';
    });

    proceedBtn_27.addEventListener('click', () => {
        item26.style.display = 'none';
        item28.style.display = 'block';
    });

    proceedBtn_28.addEventListener('click', function () {
        if (Smoke.checked) {
            item28.style.display = 'none';
            item29.style.display = 'block';

        } else if (occasionally.checked) {
            item28.style.display = 'none';
            item29.style.display = 'block';

        }
        else if (regularly.checked) {
            item28.style.display = 'none';
            item29.style.display = 'block';
        }

    });

    proceedBtn_29.addEventListener('click', function () {
        if (alcohol.checked) {
            item29.style.display = 'none';
            item30.style.display = 'block';

        } else if (drink.checked) {
            item29.style.display = 'none';
            item30.style.display = 'block';

        }
        else if (daily.checked) {
            item29.style.display = 'none';
            item30.style.display = 'block';
        }

    });

    proceedBtn_30.addEventListener('click', function () {
        if (takeaways.checked) {
            item30.style.display = 'none';
            item31.style.display = 'block';

        } else if (takeaway.checked) {
            item30.style.display = 'none';
            item31.style.display = 'block';

        }
        else if (week.checked) {
            item30.style.display = 'none';
            item31.style.display = 'block';
        }

    });

    proceedBtn_31.addEventListener('click', function () {
        if (unhealthy.checked) {
            item31.style.display = 'none';
            item32.style.display = 'block';

        } else if (snacks.checked) {
            item31.style.display = 'none';
            item32.style.display = 'block';

        }
        else if (eat.checked) {
            item31.style.display = 'none';
            item32.style.display = 'block';
        }

    });

    proceedBtn_32.addEventListener('click', function () {
        if (mins.checked) {
            item32.style.display = 'none';
            item33.style.display = 'block';

        } else if (more.checked) {
            item32.style.display = 'none';
            item33.style.display = 'block';

        }
        else if (moderate.checked) {
            item32.style.display = 'none';
            item33.style.display = 'block';
        }

    });
    proceedBtn_33.addEventListener('click', function () {
        if (a.checked) {
            item33.style.display = 'none';
            item34.style.display = 'block';

        } else if (b.checked) {
            item33.style.display = 'none';
            item34.style.display = 'block';

        }
        else if (c.checked) {
            item33.style.display = 'none';
            item34.style.display = 'block';
        }

    });
    proceedBtn_34.addEventListener('click', function () {
        if (no7.checked) {
            item34.style.display = 'none';
            item35.style.display = 'block';

        } else if (yes7.checked) {
            item34.style.display = 'none';
            item36.style.display = 'block';

        }

    });
    proceedBtn_35.addEventListener('click', function () {
        if (no8.checked) {
            item35.style.display = 'none';
            item37.style.display = 'block';

        } else if (yes8.checked) {
            item35.style.display = 'none';
            item38.style.display = 'block';

        }
    });
    proceedBtn_36.addEventListener('click', function () {
        if (Liraglutide.checked) {
            item36.style.display = 'none';
            item40.style.display = 'block';

        } else if (Mysimba.checked) {
            item36.style.display = 'none';
            item40.style.display = 'block';

        } else if (Orlistat.checked) {
            item36.style.display = 'none';
            item40.style.display = 'block';

        } else if (Semaglutide.checked) {
            item36.style.display = 'none';
            item40.style.display = 'block';

        } else if (management.checked) {
            item36.style.display = 'none';
            item40.style.display = 'block';

        }
    });
    proceedBtn_37.addEventListener('click', function () {
        if (no9.checked) {
            // item35.style.display = 'none';
            // item37.style.display = 'block'; 

        } else if (yes9.checked) {
            item37.style.display = 'none';
            item39.style.display = 'block';

        }
    });
    proceedBtn_38.addEventListener('click', () => {
        item38.style.display = 'none';
        item37.style.display = 'block';
    });
    previousBtn.addEventListener('click', function () {

        if (item1.style.display === 'block') {
            item1.style.display = 'none';
            item.style.display = 'block';
        }
    });
    previousBtn2.addEventListener('click', function () {

        if (item2.style.display === 'block') {
            item2.style.display = 'none';
            item1.style.display = 'block';
        }

    });
    previousBtn3.addEventListener('click', function () {

        if (item3.style.display === 'block') {
            item3.style.display = 'none';
            item2.style.display = 'block';
        }
    });
    previousBtn4.addEventListener('click', function () {

        if (item4.style.display === 'block') {
            item4.style.display = 'none';
            item3.style.display = 'block';
        }
    });
    previousBtn5.addEventListener('click', function () {

        if (item5.style.display === 'block') {
            item5.style.display = 'none';
            item4.style.display = 'block';
        }
    });
    previousBtn6.addEventListener('click', function () {

        if (item6.style.display === 'block') {
            item6.style.display = 'none';
            item3.style.display = 'block';
        }
    });
    previousBtn7.addEventListener('click', function () {

        if (item7.style.display === 'block') {
            item7.style.display = 'none';
            item4.style.display = 'block';
        }
    });
    previousBtn8.addEventListener('click', function () {

        if (item8.style.display === 'block') {
            item8.style.display = 'none';
            item7.style.display = 'block';
        }
    });
    previousBtn9.addEventListener('click', function () {

        if (item9.style.display === 'block') {
            item9.style.display = 'none';
            item7.style.display = 'block';
        }
    });
    previousBtn10.addEventListener('click', function () {

        if (item10.style.display === 'block') {
            item10.style.display = 'none';
            item9.style.display = 'block';
        }
    });
    previousBtn11.addEventListener('click', function () {

        if (item11.style.display === 'block') {
            item11.style.display = 'none';
            item10.style.display = 'block';
        }
    });
    previousBtn12.addEventListener('click', function () {

        if (item12.style.display === 'block') {
            item12.style.display = 'none';
            item11.style.display = 'block';
        }
    });
    previousBtn13.addEventListener('click', function () {

        if (item13.style.display === 'block') {
            item13.style.display = 'none';
            item7.style.display = 'block';
        }
    });
    previousBtn14.addEventListener('click', function () {

        if (item14.style.display === 'block') {
            item14.style.display = 'none';
            item11.style.display = 'block';
        }
    });
    previousBtn15.addEventListener('click', function () {

        if (item15.style.display === 'block') {
            item15.style.display = 'none';
            item12.style.display = 'block';
        }
    });
    previousBtn16.addEventListener('click', function () {

        if (item16.style.display === 'block') {
            item16.style.display = 'none';
            item15.style.display = 'block';
        }
    });
    previousBtn17.addEventListener('click', function () {

        if (item17.style.display === 'block') {
            item17.style.display = 'none';
            item15.style.display = 'block';
        }
    });
    previousBtn18.addEventListener('click', function () {

        if (item18.style.display === 'block') {
            item18.style.display = 'none';
            item12.style.display = 'block';
        }
    });
    previousBtn19.addEventListener('click', function () {

        if (item19.style.display === 'block') {
            item19.style.display = 'none';
            item16.style.display = 'block';
        }
    });
    previousBtn20.addEventListener('click', function () {

        if (item20.style.display === 'block') {
            item20.style.display = 'none';
            item19.style.display = 'block';
        }
    });
    previousBtn21.addEventListener('click', function () {

        if (item21.style.display === 'block') {
            item21.style.display = 'none';
            item19.style.display = 'block';
        }
    });
    previousBtn22.addEventListener('click', function () {

        if (item22.style.display === 'block') {
            item22.style.display = 'none';
            item20.style.display = 'block';
        }
    });
    previousBtn23.addEventListener('click', function () {

        if (item23.style.display === 'block') {
            item23.style.display = 'none';
            item20.style.display = 'block';
        }
    });
    previousBtn24.addEventListener('click', function () {

        if (item24.style.display === 'block') {
            item24.style.display = 'none';
            item22.style.display = 'block';
        }
    });
    previousBtn25.addEventListener('click', function () {

        if (item25.style.display === 'block') {
            item25.style.display = 'none';
            item22.style.display = 'block';
        }
    });
    previousBtn26.addEventListener('click', function () {

        if (item26.style.display === 'block') {
            item26.style.display = 'none';
            item24.style.display = 'block';
        }
    });
    previousBtn27.addEventListener('click', function () {

        if (item27.style.display === 'block') {
            item27.style.display = 'none';
            item24.style.display = 'block';
        }
    });
    previousBtn28.addEventListener('click', function () {

        if (item28.style.display === 'block') {
            item28.style.display = 'none';
            item26.style.display = 'block';
        }
    });
    previousBtn29.addEventListener('click', function () {

        if (item29.style.display === 'block') {
            item29.style.display = 'none';
            item28.style.display = 'block';
        }
    });
    previousBtn30.addEventListener('click', function () {

        if (item30.style.display === 'block') {
            item30.style.display = 'none';
            item29.style.display = 'block';
        }
    });
    previousBtn31.addEventListener('click', function () {

        if (item31.style.display === 'block') {
            item31.style.display = 'none';
            item30.style.display = 'block';
        }
    });
    previousBtn32.addEventListener('click', function () {

        if (item32.style.display === 'block') {
            item32.style.display = 'none';
            item31.style.display = 'block';
        }
    });
    previousBtn33.addEventListener('click', function () {

        if (item33.style.display === 'block') {
            item33.style.display = 'none';
            item32.style.display = 'block';
        }
    });
    previousBtn34.addEventListener('click', function () {

        if (item34.style.display === 'block') {
            item34.style.display = 'none';
            item33.style.display = 'block';
        }
    });
    previousBtn35.addEventListener('click', function () {

        if (item35.style.display === 'block') {
            item35.style.display = 'none';
            item34.style.display = 'block';
        }
    });
    previousBtn36.addEventListener('click', function () {

        if (item36.style.display === 'block') {
            item36.style.display = 'none';
            item34.style.display = 'block';
        }
    });
    previousBtn37.addEventListener('click', function () {

        if (item37.style.display === 'block') {
            item37.style.display = 'none';
            item35.style.display = 'block';
        }
    });
    previousBtn38.addEventListener('click', function () {

        if (item38.style.display === 'block') {
            item38.style.display = 'none';
            item35.style.display = 'block';
        }
    });
    previousBtn39.addEventListener('click', function () {

        if (item39.style.display === 'block') {
            item39.style.display = 'none';
            item37.style.display = 'block';
        }
    });
    previousBtn40.addEventListener('click', function () {

        if (item40.style.display === 'block') {
            item40.style.display = 'none';
            item36.style.display = 'block';
        }
    });
});
