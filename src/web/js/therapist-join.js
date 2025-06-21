$(function () {
    function loadStep(step) {
        const container = $('#step-container');
        const url = $('#therapist-join-form').data('form-url') + '?step=' + step;
        container.html('Завантаження...');
        $.get(url, function (data) {
            container.html(data);
            if (step === 'documents') {
                handleFormStepWithFiles('#form-documents', finalSubmit);
            }
        }).fail(function () {
            container.html('<div class="alert alert-danger">Не вдалося завантажити дані. Спробуйте ще раз.</div>');
        });
    }

    $('.step-btn').on('click', function () {
        loadStep($(this).data('step'));
    });

    function handleFormStepSimple(formId, nextStep) {
        $(document).on('submit', formId, function (e) {
            e.preventDefault();
            const form = $(this);
            const actionUrl = form.attr('action');
            const formData = form.serialize();

            $.post(actionUrl, formData, function (response) {
                if (response.success) {
                    if (typeof nextStep === 'function') {
                        nextStep(); // final step
                    } else {
                        loadStep(nextStep);
                    }
                } else {
                    console.error('Validation failed. Full response:', response);
                }
            }).fail(function (xhr) {
                console.error('Submit failed:', xhr.responseText);
            });
        });
    }

    function handleFormStepWithFiles(formId, nextStep) {
        $(document).on('submit', formId, function (e) {
            e.preventDefault();
            const form = $(this);
            const actionUrl = form.attr('action');
            const formData = new FormData(this);

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        if (typeof nextStep === 'function') {
                            nextStep();
                        } else {
                            loadStep(nextStep);
                        }
                    } else {
                        console.error('Validation failed. Full response:', response);
                    }
                },
                error: function (xhr) {
                    console.error('Submit failed:', xhr.responseText);
                }
            });
        });
    }

    // Фінальна відправка після успішного завантаження документів
    function finalSubmit() {
        $.post('/site/final-submit', {}, function (response) {
            if (response.success) {
                $('#step-container').html('<div class="alert alert-success">Анкету успішно відправлено!</div>');
            } else {
                $('#step-container').html('<div class="alert alert-danger">Не вдалося зберегти заявку.</div>');
                console.error('Unexpected validation response:', response);
            }
        }).fail(function () {
            $('#step-container').html('<div class="alert alert-danger">Сталася помилка. Спробуйте пізніше.</div>');
        });
    }

    // Прив'язуємо обробники для форм
    handleFormStepSimple('#form-personal-info', 'approaches');
    handleFormStepSimple('#form-approaches', 'education');
    handleFormStepSimple('#form-education', 'documents');


    // Завантажуємо перший крок
    loadStep('personal-info');
});
