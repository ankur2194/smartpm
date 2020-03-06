var form = document.querySelector('form#financial_edit');
var aliases = {
    vendor: 'Vendor / Payee',
    transaction_date: 'Transaction Date',
    job_id: 'Job',
    amount: 'Amount',
    type: 'Type',
    subtype: 'Sub Type',
    accounting_code: 'Accounting Code',
    method: 'Method',
    bank_account: 'Bank Account',
    state: 'State'
};
form.addEventListener("submit", function (e) {
    var values = validate.collectFormValues(form);
    var errors = validate(values, {
        vendor: {
            presence: true
        },
        transaction_date: {
            presence: true,
            date: true
        },
        job_id: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        amount: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        type: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        subtype: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        accounting_code: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        method: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        bank_account: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
        state: {
            presence: true,
            numericality: {
                notValid: ' contains invalid value'
            }
        },
    }, {
        format: 'flat',
        prettify: function prettify(string) {
            return aliases[string] || validate.prettify(string);
        }
    });
    if (errors) {
        e.preventDefault();
        displayValidationError(errors);
    }
});