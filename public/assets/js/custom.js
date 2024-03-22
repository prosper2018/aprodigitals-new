function payroll_overview() {
    select();

    $("#deparment_div_id").hide();
    $("#month_div_id").hide();
    $("#position_div_id").hide();
    $("#business_div_id").hide();
    $("#staff_div_id").hide();

    $("select#filter").change(function () {
        $("#department_id").val("").trigger("change");
        $("#month").val("");
        $("#position_id").val("").trigger("change");
        $("#business_id").val("").trigger("change");
        $("#staff_id").val("");

        var selected = $(this).children("option:selected").val();
        if (selected == "department_id") {
            $("#deparment_div_id").show();
            $("#month_div_id").hide();
            $("#position_div_id").hide();
            $("#business_div_id").hide();
            $("#staff_div_id").hide();
        } else if (selected == "position_id") {
            $("#deparment_div_id").show();
            $("#month_div_id").hide();
            $("#position_div_id").show();
            $("#business_div_id").hide();
            $("#staff_div_id").hide();
        } else if (selected == "month") {
            $("#month_div_id").show();
            $("#deparment_div_id").hide();
            $("#position_div_id").hide();
            $("#business_div_id").hide();
            $("#staff_div_id").hide();
        } else if (selected == "business_id") {
            $("#deparment_div_id").hide();
            $("#month_div_id").hide();
            $("#position_div_id").hide();
            $("#business_div_id").show();
            $("#staff_div_id").hide();
        } else if (selected == "staff_id") {
            $("#deparment_div_id").hide();
            $("#month_div_id").hide();
            $("#position_div_id").hide();
            $("#business_div_id").hide();
            $("#staff_div_id").show();
        } else if (selected == "all") {
            $("#deparment_div_id").show();
            $("#month_div_id").hide();
            $("#position_div_id").show();
            $("#business_div_id").show();
            $("#staff_div_id").show();
        }
    });
}

$(function () {
    var positionSelect = document.getElementById("position_id");

    // Set the selected city based on the old input value
    var oldPositionValue = "{{ old('position_id') }}";
    if (oldPositionValue) {
        var positionOption = positionSelect.querySelector(
            'option[value="' + oldPositionValue + '"]'
        );
        if (positionOption) {
            positionSelect.selected = true;
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    if (document.getElementById("chartjs-dashboard-bar")) {
        // Bar chart
        new Chart(document.getElementById("chartjs-dashboard-bar"), {
            type: "bar",
            data: {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                datasets: [
                    {
                        label: "Last year",
                        backgroundColor: window.theme.primary,
                        borderColor: window.theme.primary,
                        hoverBackgroundColor: window.theme.primary,
                        hoverBorderColor: window.theme.primary,
                        data: [54, 67, 41, 55, 62, 45, 55, 73, 60, 76, 48, 79],
                        barPercentage: 0.325,
                        categoryPercentage: 0.5,
                    },
                    {
                        label: "This year",
                        backgroundColor: window.theme["primary-light"],
                        borderColor: window.theme["primary-light"],
                        hoverBackgroundColor: window.theme["primary-light"],
                        hoverBorderColor: window.theme["primary-light"],
                        data: [69, 66, 24, 48, 52, 51, 44, 53, 62, 79, 51, 68],
                        barPercentage: 0.325,
                        categoryPercentage: 0.5,
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                cornerRadius: 15,
                legend: {
                    display: false,
                },
                scales: {
                    yAxes: [
                        {
                            gridLines: {
                                display: false,
                            },
                            ticks: {
                                stepSize: 20,
                            },
                            stacked: true,
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                color: "transparent",
                            },
                            stacked: true,
                        },
                    ],
                },
            },
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    if (document.getElementById("datetimepicker-dashboard")) {
        $("#datetimepicker-dashboard").datetimepicker({
            inline: true,
            sideBySide: false,
            format: "L",
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    if (document.getElementById("chartjs-dashboard-pie")) {
        // Pie chart
        new Chart(document.getElementById("chartjs-dashboard-pie"), {
            type: "pie",
            data: {
                labels: ["Direct", "Affiliate", "E-mail", "Other"],
                datasets: [
                    {
                        data: [2602, 1253, 541, 1465],
                        backgroundColor: [
                            window.theme.primary,
                            window.theme.warning,
                            window.theme.danger,
                            "#E8EAED",
                        ],
                        borderWidth: 5,
                        borderColor: window.theme.white,
                    },
                ],
            },
            options: {
                responsive: !window.MSInputMethodContext,
                maintainAspectRatio: false,
                cutoutPercentage: 70,
                legend: {
                    display: false,
                },
            },
        });
    }
});

function handleFileInput(inputId, previewId) {
    var fileInput = document.getElementById(inputId);
    var preview = document.getElementById(previewId);

    function previewFile() {
        var file = fileInput.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = "block";
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    fileInput.addEventListener("change", previewFile);

    // Check if file input already has a file selected when the page loads
    if (fileInput.files.length > 0) {
        previewFile();
    }
}

document.addEventListener("DOMContentLoaded", function () {
    $("#datatables-dashboard-projects").DataTable({
        pageLength: 6,
        lengthChange: false,
        bFilter: false,
        autoWidth: false,
    });
});

function togglePasswordVisibility(fieldId, iconId) {
    const passwordField = document.getElementById(fieldId);
    const visibilityIcon = document.getElementById(iconId);

    if (passwordField.type === "password") {
        passwordField.type = "text";
        visibilityIcon.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Font Awesome Eye Slash Icon
    } else {
        passwordField.type = "password";
        visibilityIcon.innerHTML = '<i class="fas fa-eye"></i>'; // Font Awesome Eye Icon
    }
}

select();
if (document.getElementById("page_1")) {
    CKEDITOR.replace("page_1");
}

if (document.getElementById("page_2")) {
    CKEDITOR.replace("page_2");
}

if (document.getElementById("post_content_excerpt")) {
    CKEDITOR.replace("post_content_excerpt");
}

function number_format(
    number,
    decimals = 2,
    decimalSeparator = ".",
    thousandSeparator = ","
) {
    number = parseFloat(number);

    if (isNaN(number) || !isFinite(number)) {
        return "0.00";
    }

    // Round to specified number of decimal places
    number = number.toFixed(decimals);

    // Add thousands separator
    number = number.replace(
        /(\d)(?=(\d{3})+(?!\d))/g,
        "$1" + thousandSeparator
    );

    // Replace decimal separator
    number = number.replace(".", decimalSeparator);

    return number;
}

$("#selectAllBoxes").on("click", function () {
    var rows = table.rows().nodes();
    $('input[type="checkbox"]', rows).prop("checked", this.checked);
});

$("#selectAllCat").on("click", function () {
    var rows = categories_table.rows().nodes();
    $('input[type="checkbox"]', rows).prop("checked", this.checked);
});

$("#selectAllComm").on("click", function () {
    var rows = comments_table.rows().nodes();
    $('input[type="checkbox"]', rows).prop("checked", this.checked);
});

function toggleform(repayment_type) {
    if (repayment_type == "2") {
        $("#number_of_days_id").show();
        $("#number_of_repayments_id").show();
    } else if (repayment_type == "3") {
        $("#number_of_repayments_id").hide();
        $("#number_of_days_id").hide();
    } else {
        $("#number_of_days_id").hide();
        $("#number_of_repayments_id").show();
    }
}

$(function() {
    $("#toggleButton").click(function() {
        if ($(this).hasClass("off")) {
            $("#currency_type").val("naira");
            $(this).text("NAIRA").removeClass("off").addClass("on");
        } else {
            $("#currency_type").val("usd");
            $(this).text("USD").removeClass("on").addClass("off");
        }
    });
});

function getActionLabel(action, receipient, action_type = "multiple") {
    var label = "",
        action_number = (action_type == "multiple") ? "all" : "";

    switch (action) {
        case "approve":
            label =
                "By clicking OK, you are approving " +
                action_number +
                " the selected "+receipient+" Application(s)!";
            break;
        case "reject":
            label =
                "Are you sure you want to reject " +
                action_number +
                " the selected "+receipient+" Application(s)?  Click OK to Enter your reason.";
            break;
        case "delete":
            label =
                "By clicking OK, you are deleting " +
                action_number +
                " the selected "+receipient+" Application(s)!";
            break;
        default:
            label = "Are you sure you want to perform this action?";
    }
    return label;
}