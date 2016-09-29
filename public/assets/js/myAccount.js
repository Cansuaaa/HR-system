$.fn.editable.defaults.mode = 'inline';

$addNewSkill = 1;
$addNewProject = 1;
$addNewExperience = 1;
function showAddExperienceContainer() {
    $('#addNewExperienceContainer').fadeIn('fast');
    $('#addItemToTableExperience')
            .text("Cancel")
            .attr("onclick", "hideAddExperienceContainer()");
}
function hideAddExperienceContainer() {
    $('#addNewExperienceContainer').fadeOut('fast');
    $('#addItemToTableExperience')
            .text("Add new experience ")
            .append("<i class='fa fa-plus'></i>")
            .removeAttr("onclick")
            .attr("onclick", "showAddExperienceContainer()");
}
$(function () {
    $(document).on("click", "#btnAddNewExperience", function () {
        $companyName = $('#experienceCompanyName').val();
        $title = $('#experienceTitle').val();
        $location = $('#locationExperience').val();
        $monthFrom = $('#experienceMonthFrom').val();
        $yearFrom = $('#experienceYearFrom').val();
        $monthTo = $('#experienceMonthTo').val();
        $yearTo = $('#experienceYearTo').val();
        if  ($companyName !== "" && $title !== "" && $location !== "" && $monthFrom !== "" && $yearFrom !== "" && $monthTo !== "" && $yearTo !== "") {
            $('#messageWrongExperience').text('');
                
        } else {
            $('#messageWrongExperience').text("Fill every field, before add a new one!")
                    .css("color", "tomato")
        }
    });
});
function removeExperience(num) {
    $('#notesBackgroundResources').show('fast');
    $("#removeBackgroundText").slideToggle('slow');
    $(document.body).on('click', '#acceptDelete', function () {
        ajaxRemoveExperience(num)
    });
}
function ajaxRemoveExperience(num) {
    var myData = {
        company: $('#companyNameNewExperience' + num).text(),
        title: $('#titleNewExperience' + num).text(),
        location: $('#locationNewExperience' + num).text(),
        monthFrom: $('#monthFromNewExperience' + num).text(),
        yearFrom: $('#yearFromNewExperience' + num).text(),
        monthTo: $('#monthToNewExperience' + num).text(),
        yearTo: $('#yearToNewExperience' + num).text()
    };
    $.ajax({
        type: 'POST',
        url: '/ajax/deleteExperience',
        data: myData,
        dataType: "json",
        success: function (data) {
            $(document.body).find('#experience' + num).remove();
        },
        error: function (e) {
            $('#messageWrongExperience').text('We have a problem, try again later!');
        }
    });
}

$(function () {
    $(document).on("click", "#btnAddNewProject", function () {
        $name = $('#projectName').val();
        $year = $('#projectYear').val();
        $month = $('#projectMonth').val();
        $url = $('#projectURL').val();
        if  ($name !== "" && $year !== "" && $month !== "" && $url !== "") {
            $('#messageWrongProject').text("");
        } else {
            $('#messageWrongProject').text("Fill every field, before add a new one!")
                    .css("color", "tomato")
        }
    });
});
function removeProject(num) {
    $("#removeBackgroundText").slideToggle('slow');
    $('#notesBackgroundResources').show('fast');
    $(document.body).on('click', '#acceptDelete', function () {
        ajaxRemoveProject(num)
    });
}
function ajaxRemoveProject(num) {
    var myData = {
        name: $('#nameNewProject' + num).text(),
        month: $('#monthNewProject' + num).text(),
        year: $('#yearNewProject' + num).text(),
        url: $('#urlNewProject' + num).text(),
        description: $('#descriptionNewProject' + num).text()
    };
    $.ajax({
        type: 'POST',
        url: '/ajax/deleteProject',
        data: myData,
        dataType: "json",
        success: function (data) {
            $(document.body).find('#project' + num).remove();
        },
        error: function (e) {
            $('#messageWrongProject').text('We have a problem, try again later!')
        }
    });
}
function showAddTimeToNewProjectContainer() {
    $('#addTimeToNewProjectContainer').fadeIn('fast');
    $('#addTimeToNewProject')
            .text("Cancel")
            .attr("onclick", "hideAddTimeToNewProjectContainer()");
}
function hideAddTimeToNewProjectContainer() {
    $('#addTimeToNewProjectContainer').fadeOut('fast');
    $('#addTimeToNewProject')
            .text("Add new project ")
            .append("<i class='fa fa-plus'></i>")
            .removeAttr("onclick")
            .attr("onclick", "showAddTimeToNewProjectContainer()");
}
function showAddNewSkillContainer() {
    $('#formNewSkills').fadeIn('slow');
    $('#addItemToTable')
            .text("Cancel")
            .attr("onclick", "hideAddNewSkillContainer()");
}
function hideAddNewSkillContainer() {
    $('#formNewSkills').fadeOut('fast');
    $('#addItemToTable')
            .text("add new skill ")
            .append("<i class='fa fa-plus'></i>")
            .removeAttr("onclick")
            .attr("onclick", "showAddNewSkillContainer()");
}
$(function () {
    $(document).on("click", "#btnAddNewSkill", function () {
        $skill = $('#addNewSkill').val();
        $exp = $('#addNewExperiance').val();
        if  ($skill !== "" && $exp !== "") {
            $('#messageWrong').text("");
        } else {
            $('#messageWrong').text("Fill every field, before add a new one!")
                    .css("color", "tomato")
        }
    });
});

function removeLanguage(num) {
    $('#notesBackgroundResources').show('fast');
    $("#removeBackgroundText").slideToggle('slow');
    $(document.body).on('click', '#acceptDelete', function () {
        ajaxRemoveLanguage(num)
    });
}
function ajaxRemoveLanguage(num) {
    var myData = {
        skill: $('#lang' + num).text(),
        experience: $('#exp' + num).text()
    };
    $.ajax({
        type: 'POST',
        url: '/ajax/deleteSkill',
        data: myData,
        dataType: "json",
        success: function (data) {
            $(document.body).find('#language' + num).remove();
        },
        error: function (e) {
            $('#messageWrong').text('We have a problem, try again later!')
        }
    });
}
$(function () {

    // Add new experience
    $('#addNewExperienceForm').submit(function(e){
     var url = "/ajax/addNewExperience";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#addNewExperienceForm").serialize(),
            dataType: "json",
            success: function(data)
            {
                if ( data.success == true) {
                    $('#experienceCompanyName').val("");
                    $('#experienceTitle').val("");
                    $('#locationExperience').val("");
                    $('#experienceMonthFrom').val("");
                    $('#experienceMonthTo').val("");
                    $('#experienceYearTo').val("");
                    $('#experienceYearFrom').val("");
                    $('#descriptionExperience').val("");
                    $('#messageWrongExperience').text("");
                    $description = $('#descriptionExperience').val();
                    $('#newExperienceContainer').append("<form id='formNewExperience" + $addNewExperience + "' name='formNewExperience" + $addNewExperience + "'><div class='projects col-md-12' id='experience" + $addNewExperience + "'><span>Company name: <a href='#' class='editableExperienceRow" + $addNewExperience + "' id='companyNameNewExperience" + $addNewExperience + "'>" + $companyName + "</a></span><span class='removeProject' onclick='removeExperience(" + $addNewExperience + ")' id='removeNewExperience" + $addNewExperience + "' name='removeNewExperience" + $addNewExperience + "'>&#10006;</span><div><span>Title:  <a href='#' id='titleNewExperience" + $addNewExperience + "' class='editableExperienceRow" + $addNewExperience + "' >" + $title + "</a></span></div><div>Location: <a href='#' class='editableExperienceRow" + $addNewExperience + "' id='locationNewExperience" + $addNewExperience + "'>" + $location + "</a></div><div>Period from: <a href='#' class='editableExperienceRow" + $addNewExperience + "' id='monthFromNewExperience" + $addNewExperience + "'>" + $monthFrom + "</a>.<a href='#' class='editableExperienceRow" + $addNewExperience + "' id='yearFromNewExperience" + $addNewExperience + "'>" + $yearFrom + "</a><span> year to: <a href='#' class='editableExperienceRow" + $addNewExperience + "' id='monthToNewExperience" + $addNewExperience + "'>" + $monthTo + "</a>.<a href='#' class='editableExperienceRow" + $addNewExperience + "' id='yearToNewExperience" + $addNewExperience + "'>" + $yearTo + "</a></span></div></div></form>");
                    if  ($description !== ""){
                        $('#newExperienceContainer').find("#experience" + $addNewProject).append("<div>Description: <a href='#' class='editableExperienceRow" + $addNewExperience + "'>" + $description + "</a></div>");
                    }
                    editableExperience($addNewExperience);
                    $('#addedItemMyAccount').fadeIn('fast').delay(2000).fadeOut('slow');
                    ++$addNewExperience;
                }
                else {
                    $('#messageWrongExperience').text(data.msg);
                }
            },
            error: function () {
                $('#messageWrongExperience').text('We have a problem, try again later!');
            }
        });
        e.preventDefault();
    });

    //Add new skill
    $('#formNewSkills').submit(function(e){
     var url = "/ajax/addNewSkill";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#formNewSkills").serialize(),
            dataType: "json",
            success: function(data)
            {
                if ( data.success == true) {
                    $('#addNewSkill').val("");
                    $('#addNewExperiance').val("");
                    $('#newSkillContainer').append("<div class='skills' id='language" + $addNewSkill + "' ><a href='#'  class='newSkillRow" + $addNewSkill + "'>" + $skill + "</a><span> with experiance of: </span><a href='#' id='exp" + $addNewSkill + "' class='newSkillRow" + $addNewSkill + "'>" + $exp + "</a><span onclick='removeLanguage(" + $addNewSkill + ")' class='removeLanguage' id='removeNewSkill" + $addNewSkill + "' name='removeNewSkill" + $addNewSkill + "' >&#10006;</span></div>");
                    editableSkills($addNewSkill);
                    $('#addedItemMyAccount').fadeIn('fast').delay(2000).fadeOut('slow');
                    $addNewSkill++;
                }
                else {
                    $('#messageWrong').text(data.msg).css('color', 'tomato');
                }
            },
            error: function () {
                $('#messageWrong').text('We have a problem, try again later!');
            }
        });
        e.preventDefault();
    });

    // Add new project
    $('#addNewProjectForm').submit(function(e){

        var url = "/ajax/addNewProject";
        $.ajax({
            type: "POST",
            url: url,
            data: $("#addNewProjectForm").serialize(),
            dataType: "json",
            success: function(data)
            {
                if ( data.success == true) {
                    $('#projectName').val("");
                    $('#projectYear').val("");
                    $('#projectMonth').val("");
                    $('#description').val("");
                    $('#projectURL').val("");
                    $description = $('#description').val();
                    $('#newProjectsContainer').append("<form id='formNewProject" + $addNewProject + "' name='formNewProject" + $addNewProject + "'><div class='projects col-md-12' id='project" + $addNewProject + "'><span>Name: <a href='#' class='editableProjectRow" + $addNewProject + "' id='nameNewProject" + $addNewProject + "'>" + $name + "</a></span><span class='removeProject' onclick='removeProject(" + $addNewProject + ")' id='removeNewProject" + $addNewProject + "' name='removeNewProject" + $addNewProject + "'>&#10006;</span><div><span>Working since <a href='#' class='editableProjectRow" + $addNewProject + "' id='monthNewProject" + $addNewProject + "'>" + $month + "</a>.<a href='#' class='editableProjectRow" + $addNewProject + "' id='yearNewProject" + $addNewProject + "'>" + $year + "</a> year.</span></div><div>My project is on: <a href='#' class='editableProjectRow" + $addNewProject + "' id='urlNewProject" + $addNewProject + "'>" + $url + "</a></div></div></form>");
                    if  ($description !== ""){
                        $('#newProjectsContainer').find("#project" + $addNewProject).append('<div>Description: <a href="#" class="editableProjectRow' + $addNewProject + '"  id="descriptionNewProject' + $addNewProject + '">' + $description + '</a></div>');
                    }
                    editableProjects($addNewProject);
                    $('#addedItemMyAccount').fadeIn('fast').delay(2000).fadeOut('slow');
                    ++$addNewProject;
                }
                else {
                    $('#messageWrongProject').text(data.msg).css('color', 'tomato');
                }
            },
            error: function () {
                $('#messageWrongProject').text('We have a problem, try again later!');
            }
        });
        e.preventDefault();
    });
});
//Edit Experience
function editableExperience(num) {
    $(".editableExperienceRow" + num).editable({
        name: 'Update Experience',
        url: '/ajax/updateExperience',
        pk: num,
        success: function (data) {
            var myData = JSON.parse(data);
            $('#updatedItemMyAccount').fadeIn('fast').delay(2000).fadeOut('slow');
        },
        error: function () {
            $('#messageWrongExperience').text('We have a problem, try again later!');
        }
    });
}
//Edit Skills
function editableSkills(num) {
    $(".newSkillRow" + num).editable({
        name: 'Update Skill',
        url: '/ajax/updateSkill',
        pk: num,
        success: function (data) {
            var myData = JSON.parse(data);
            $('#updatedItemMyAccount').fadeIn('fast').delay(2000).fadeOut('slow');
        },
        error: function () {
            $('#messageWrong').text('We have a problem, try again later!');
        }
    });
}
//Edit Projects
function editableProjects(num) {
    $(".editableProjectRow" + num).editable({
        name: 'Update Project',
        url: '/ajax/updateProject',
        pk: num,
        success: function (data) {
            var myData = JSON.parse(data);
            $('#updatedItemMyAccount').fadeIn('fast').delay(2000).fadeOut('slow');
        },
        error: function () {
            $('#messageWrongProject').text('We have a problem, try again later!');
        }
    });
}
$(function () {
    var availableTags = [
        "JavaScript", "PHP", "ASP", "C#", "C", "C++", "Visual Basic", "Java",
        "JADE", "Karel", "Karel++", "L#.NET", "Perl", "Assembly language", "Delphi", "Rubi", "Swift",
        "Python", "Groovy", "MATLAB", "PL", "SQL", "GO", "SAS", "Scratch",
        "ABAP", "COBOL", "D", "Dart", "Transact-SQL", "Fortran", "Lua", "Ada", "Lisp", "Scala",
        "Prolog", "Scheme", "LabVIEW", "Logo", "RPG(OS/400)", "Haskell", "Erlang", "Apex", "Ladder Logic",
        "Rust", "Bash", "Q", "F#", "Awk", "VHDL", "Alice", "VBScript", "C shell"
    ];
    $( "#addNewSkill" ).autocomplete({
        source: availableTags
    });
});
$(function () {
    $('#cancelDelete').click(function () {
        $('#removeBackgroundText').fadeOut();
        $('#notesBackgroundResources').fadeOut();
    });
    $('#acceptDelete').click(function () {
        $('#removeBackgroundText').fadeOut();
        $('#notesBackgroundResources').fadeOut();
        $('#removeItemMyAccount').fadeIn('fast').delay(2000).fadeOut('slow');
    });
    $('#notesBackgroundResources').click(function () {
        $('#removeBackgroundText').fadeOut();
        $('#notesBackgroundResources').fadeOut();
    });
});