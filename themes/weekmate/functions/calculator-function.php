<?php

//Shortcode for Weekmate Calculator
function weekmate_calculator_shortcode($atts) {

    $atts = shortcode_atts([
        'type' => 'salary' // default
    ], $atts);

    ob_start();


// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
// Salary Calculator
// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
    if ($atts['type'] === 'salary') { ?>

        <div class="salary__card" role="application" aria-label="Salary Hike Calculator">
      <div style="width: 100%;">
        

        <section class="salary__form" aria-labelledby="inputs">

          <div class="salary__field">
            <div class="salary__field-label">
              <div class="salary__label-name">Current annual CTC</div>
              <div class="salary__label-hint">Before hike</div>
            </div>
            <input id="currentCTC" min="0" max="100000000" class="salary__input" type="text" inputmode="numeric"
              aria-label="Current CTC" />

          </div>

          <div class="salary__field">
            <div class="salary__field-label">
              <div class="salary__label-name">Hike %</div>
              <div class="salary__label-hint">Drag or type</div>
            </div>
            <div class="salary__slider-wrap">
              <input id="hikeRange" class="salary__range" type="range" min="0" max="1000" value="10" step="0.1"
                aria-label="Hike percent slider" />
              <input id="hikePct" class="salary__chip" type="number" min="0" max="1000" step="1"
                aria-label="Hike percentage" />
            </div>
          </div>

          <div class="salary__field">
            <div class="salary__field-label">
              <div class="salary__label-name">New annual CTC</div>
              <div class="salary__label-hint">After hike</div>
            </div>
            <input id="newCTC" min="0" max="100000000" class="salary__input" type="text" inputmode="numeric"
              aria-label="New CTC" />
          </div>
          <div id="newCtcError" class="salary__note" style="color:#c62828; display:none;">
            New CTC must be greater than or equal to Current CTC
          </div>
          <div id="ctcLimitError" class="salary__note error-msg" style="display:none;">
            Please enter a valid CTC number.
          </div>

          <div class="salary__row">
            <div class="salary__col salary__field">
              <div class="salary__field-label">
                <div class="salary__label-name">Yearly increase</div>
                <div class="salary__label-hint">Annual</div>
              </div>
              <div class="salary__readonly" id="absIncrease" aria-live="polite"></div>
            </div>
            <div class="salary__col salary__field">
              <div class="salary__field-label">
                <div class="salary__label-name">Monthly increase</div>
                <div class="salary__label-hint">Approx.</div>
              </div>
              <div class="salary__readonly" id="monthlyIncrease" aria-live="polite"></div>
            </div>
          </div>


          <div class="salary__footer">
            <button class="salary__btn" id="salary-resetBtn">Reset</button>
          </div>

        </section>
      </div>

      <aside class="salary__aside">
        <div class="salary__result-card">
          <div style="display:flex;justify-content:space-between;align-items:center">
            <div>
              <div class="salary__muted">Before</div>
              <div class="salary__big-num" id="displayBefore">—</div>
            </div>
            <div style="text-align:right">
              <div class="salary__muted">After</div>
              <div class="salary__big-num" id="displayAfter">—</div>
            </div>
          </div>

          <div style="height:12px"></div>

          <div class="salary__stat">
            <div>
              <div class="salary__stat-sub">Hike %</div>
              <div class="salary__muted-2" id="displayPct">0%</div>
            </div>
            <div class="salary__pill" id="pctPill"></div>
          </div>

          <div class="salary__stat">
            <div>
              <div class="salary__stat-sub">Annual increase</div>
              <div class="salary__muted-2" id="displayIncAnn">—</div>
            </div>

          </div>

          <div class="salary__stat">
            <div>
              <div class="salary__stat-sub">Approx. monthly increase</div>
            </div>
            <div class="salary__muted-2" id="displayIncMo">—</div>
          </div>

          <div style="height:10px"></div>
          <div class="salary__note">Tip: You can edit either the Hike % or the New CTC the other values will update
            automatically.</div>
        </div>
      </aside>

    </div>


    <?php }










// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
// HRA Calculator
// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
    if ($atts['type'] === 'hra') { ?>

    

    <div class="hra-calculator">

  <div class="hra-calculator__card">
    <h1 class="hra-calculator__title">HRA Calculator</h1>

    <form id="hraForm">
      <div class="hra-calculator__row">
        <div>
          <label class="hra-calculator__label">Basic Salary (Yearly)</label>
          <input type="number" id="basic" class="hra-calculator__input" value="0">
        </div>

        <div>
          <label class="hra-calculator__label">Dearness Allowance (Yearly)</label>
          <input type="number" id="da" class="hra-calculator__input" value="0">
        </div>
      </div>

      <div class="hra-calculator__row">
        <div>
          <label class="hra-calculator__label">HRA Received (Yearly)</label>
          <input type="number" id="hra" class="hra-calculator__input" value="0">
        </div>

        <div>
          <label class="hra-calculator__label">Rent Paid (Yearly)</label>
          <input type="number" id="rent" class="hra-calculator__input" value="0">
        </div>
      </div>

        <div class="hra-calculator__row">
        <div style="grid-column: 1 / -1;">
          <label class="hra-calculator__label">Do you live in a metro city? (For example: Delhi, Mumbai, Kolkata, or Chennai.)</label>

          <div class="hra-city-toggle">
            <label class="option">
              <input type="radio" name="cityType" value="metro" checked>
              <span>Yes</span>
            </label>

            <label class="option">
              <input type="radio" name="cityType" value="non-metro">
              <span>No</span>
            </label>
          </div>
        </div>
      </div>



      <div class="hra-calculator__actions">
        <button type="reset" class="button button--ghost" id="hra-resetBtn">Reset</button>
      </div>

      <p class="hra-calculator__note">
        Exempt = Least of (HRA, Rent - 10% of Salary, <strong>40% (Non-Metro) / 50% (Metro)</strong>)
      </p>

    </form>
  </div>

  <div class="hra-calculator__card hra-calculator__card--results">
    <div class="hra-results">
      <div class="hra-results__item"><span>Actual HRA Received</span><strong id="outActual" class="hra-results__value">₹0.00</strong></div>
      <div class="hra-results__item"><span>Rent Over 10% Salary</span><strong id="outRent" class="hra-results__value">₹0.00</strong></div>
      <div class="hra-results__item"><span id="percentLabel">40% Salary</span><strong id="outPercent" class="hra-results__value">₹0.00</strong></div>
      <div class="hra-results__item"><span>Exempt HRA</span><strong id="outExempt" class="hra-results__value">₹0.00</strong></div>
      <div class="hra-results__item"><span>Taxable HRA</span><strong id="outTax" class="hra-results__value">₹0.00</strong></div>
    </div>
  </div>
</div>


    <script>
   

    </script>

    <?php }










// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
// Gratuity Calculator
// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
    if ($atts['type'] === 'gratuity') { ?>

        <div class="gra-calculator">
            <div class="gra-calculator__card">
                

                <form id="graForm">
                    
                    <div class="gra-calculator__row">
                        <div>
                            <label class="gra-calculator__label">Last Drawn Basic Salary (Monthly)</label>
                            <input type="number" id="basicGra" class="gra-calculator__input" value="0">
                        </div>

                        <div>
                            <label class="gra-calculator__label">Dearness Allowance (Monthly)</label>
                            <input type="number" id="daGra" class="gra-calculator__input" value="0">
                        </div>
                    </div>

                    <div class="gra-calculator__row">
                        <div>
                            <label class="gra-calculator__label">Total Completed Years of Service</label>
                            <input type="number" id="yearsGra" class="gra-calculator__input" value="5" min="5" max="50">
                            <p class="gra-calculator__note">Minimum 5 years of service is required for eligibility.</p>
                        </div>
                        
                        <div class="gra-checkbox-field">
                            <label class="gra-calculator__label" style="margin-bottom: 12px;">Is the Employer Covered under the Act?</label>
                            <div class="gra-city-toggle">
                                <label class="option">
                                    <input type="radio" name="coveredType" value="covered" checked>
                                    <span>Yes (15 days' wages)</span>
                                </label>

                                <label class="option">
                                    <input type="radio" name="coveredType" value="not-covered">
                                    <span>No (Half a month's wages)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="gra-calculator__card gra-calculator__card--results">
                <h2 class="gra-calculator__results-title">Your Estimated Gratuity</h2>
                <div class="gra-results">
                    <div class="gra-results__item">
                        <span>Last Drawn Salary (Basic + DA)</span>
                        <strong id="outSalaryGra" class="gra-results__value">₹0.00</strong>
                    </div>
                    <div class="gra-results__item">
                        <span>Service Period (Years)</span>
                        <strong id="outYearsGra" class="gra-results__value">0</strong>
                    </div>
                    <div class="gra-results__item gra-results__item--highlight">
                        <span>Total Gratuity Amount</span>
                        <strong id="outGratuity" class="gra-results__value gra-results__value--highlight">₹0.00</strong>
                    </div>
                </div>

                <div class="gra-calculator__actions">
                    <button type="reset" class="button button--ghost" id="resetBtnGra">Reset</button>
                </div>
            </div>
        </div>

    <?php }










// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
// PF and ESI Calculator
// ===============================
// ===============================
// ===============================
// ===============================
// ===============================

if ($atts['type'] === 'pfandesi') { ?>

     <div class="pf-esi">
  <form class="pf-esi__form" novalidate>

    <div class="pf-esi__row">
      <div class="pf-esi__field">
        <label for="pf-esi-basic-salary" class="pf-esi__label">Basic Salary (₹)</label>
        <input
          type="number"
          id="pf-esi-basic-salary"
          class="pf-esi__input"
          name="basic_salary"
          placeholder="Enter basic salary"
          required
          min="0"
          step="0.01"
        />
        <span class="pf-esi__error" aria-live="polite"></span>
      </div>

      <div class="pf-esi__field">
        <label for="pf-esi-hra" class="pf-esi__label">HRA (₹)</label>
        <input
          type="number"
          id="pf-esi-hra"
          class="pf-esi__input"
          name="hra"
          placeholder="Enter HRA"
          required
          min="0"
          step="0.01"
        />
        <span class="pf-esi__error" aria-live="polite"></span>
      </div>
    </div>

    <div class="pf-esi__row">
      <div class="pf-esi__field">
        <label for="pf-esi-allowances" class="pf-esi__label">Other Allowances (₹)</label>
        <input
          type="number"
          id="pf-esi-allowances"
          class="pf-esi__input"
          name="other_allowances"
          placeholder="Enter other allowances"
          required
          min="0"
          step="0.01"
        />
        <span class="pf-esi__error" aria-live="polite"></span>
      </div>

      <div class="pf-esi__field pf-esi__field--read-only">
        <label for="pf-esi-gross" class="pf-esi__label">Gross Salary (₹)</label>
        <input
          type="number"
          id="pf-esi-gross"
          class="pf-esi__input pf-esi__input--read-only"
          name="gross_salary"
          readonly
        />
      </div>
    </div>

    <div class="pf-esi__section-title">PF Rates (%)</div>
    <div class="pf-esi__row">
      <div class="pf-esi__field">
        <label for="pf-esi-emp-pf" class="pf-esi__label">Employee PF (%)</label>
        <input
          type="number"
          id="pf-esi-emp-pf"
          class="pf-esi__input"
          name="employee_pf"
          value="12"
          required
          min="0"
          max="100"
          step="0.01"
        />
        <span class="pf-esi__error" aria-live="polite"></span>
      </div>

      <div class="pf-esi__field">
        <label for="pf-esi-empr-pf" class="pf-esi__label">Employer PF (%)</label>
        <input
          type="number"
          id="pf-esi-empr-pf"
          class="pf-esi__input"
          name="employer_pf"
          value="12"
          required
          min="0"
          max="100"
          step="0.01"
        />
        <span class="pf-esi__error" aria-live="polite"></span>
      </div>
    </div>

    <div class="pf-esi__section-title">ESI Rates (%)</div>
    <div class="pf-esi__row">
      <div class="pf-esi__field">
        <label for="pf-esi-emp-esi" class="pf-esi__label">Employee ESI (%)</label>
        <input
          type="number"
          id="pf-esi-emp-esi"
          class="pf-esi__input"
          name="employee_esi"
          value="0.75"
          required
          min="0"
          max="100"
          step="0.01"
        />
        <span class="pf-esi__error" aria-live="polite"></span>
      </div>

      <div class="pf-esi__field">
        <label for="pf-esi-empr-esi" class="pf-esi__label">Employer ESI (%)</label>
        <input
          type="number"
          id="pf-esi-empr-esi"
          class="pf-esi__input"
          name="employer_esi"
          value="3.25"
          required
          min="0"
          max="100"
          step="0.01"
        />
        <span class="pf-esi__error" aria-live="polite"></span>
      </div>
    </div>

    <button type="Reset" class="pf-esi__button">Reset</button>

    <div class="pf-esi__results" aria-live="polite">
      <div class="pf-esi__result-item">
        <span class="pf-esi__result-label">Employee PF (₹):</span>
        <span class="pf-esi__result-value" id="pf-esi-emp-pf-result">0</span>
      </div>
      <div class="pf-esi__result-item">
        <span class="pf-esi__result-label">Employer PF (₹):</span>
        <span class="pf-esi__result-value" id="pf-esi-empr-pf-result">0</span>
      </div>
      <div class="pf-esi__result-item">
        <span class="pf-esi__result-label">Employee ESI (₹):</span>
        <span class="pf-esi__result-value" id="pf-esi-emp-esi-result">0</span>
      </div>
      <div class="pf-esi__result-item">
        <span class="pf-esi__result-label">Employer ESI (₹):</span>
        <span class="pf-esi__result-value" id="pf-esi-empr-esi-result">0</span>
      </div>
      <div class="pf-esi__result-item pf-esi__result-item--highlight">
        <span class="pf-esi__result-label">Total Employee Deduction (₹):</span>
        <span class="pf-esi__result-value" id="pf-esi-total-emp-deduction">0</span>
      </div>
    </div>
  </form>
</div>   

    <?php }











// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
// Salary Slip Generator
// ===============================
// ===============================
// ===============================
// ===============================
// ===============================
if ($atts['type'] === 'payslip') { ?>

    <div class="payslip">

  <!-- Upload + Month -->
  <div class="payslip__row payslip__row--header">
    <div class="payslip__row--header-logo">
    <label for="payslip-logo" class="payslip__upload">
      <img id="payslip-logo-preview" class="payslip__upload-preview" style="display:none">
      <span class="payslip__upload-text">Upload</span>
    </label>
    <input type="file" id="payslip-logo" accept="image/*" hidden>
    <span class="payslip__upload-text">Upload Logo</span>
    </div>

    

    <div class="payslip__month">
      <span class="payslip__month-label">Payslip For the Month</span>
      <span id="payslip-month" class="payslip__month-value"></span>
    </div>

  </div>


  <!-- Company Info -->
  <div class="payslip__section">
    <h3 class="payslip__title">Company Details <span class="payslip-field-required">*</span></h3>

    <input id="payslip-company-name" class="payslip__input" placeholder="Company Name">
    <input id="payslip-company-address" class="payslip__input" placeholder="Company Address">
    <input id="payslip-company-location" class="payslip__input" placeholder="Country">
  </div>


  <!-- Employee Summary -->
  <div class="payslip__section">
    <h3 class="payslip__title">Employee Pay Summary <span class="payslip-field-required">*</span></h3>

    <div class="payslip__grid">
      <div class="payslip__item">
        <label>Employee Name:</label>
        <input id="payslip-emp-name" class="payslip__input" placeholder="Employee Name">
      </div>
      <div class="payslip__item">
        <label>Employee ID:</label>
        <input id="payslip-emp-id" class="payslip__input" placeholder="Employee Id">
      </div>
    </div>

    <div class="payslip__grid">
      <div class="payslip__item">
        <label>Pay Period:</label>
        <input id="payslip-period" class="payslip__input" type="month">
      </div>
      <div class="payslip__item">
        <label>Paid Days:</label>
        <input id="payslip-paid-days" class="payslip__input" type="number" value="30">
      </div>
    </div>

    <div class="payslip__grid">
      <div class="payslip__item">
        <label>Loss of Pay Days:</label>
        <input id="payslip-loss-days" class="payslip__input" type="number" value="0">
      </div>
      <div class="payslip__item">
        <label>Pay Date:</label>
        <input id="payslip-date" class="payslip__input" type="date">
      </div>
    </div>
  </div>


  <!-- Income Details -->
  <div class="payslip__section">
    <h3 class="payslip__title">Income Details <span class="payslip-field-required">*</span></h3>

    <div class="payslip__table-wrap">

      <!-- Earnings Table -->
      <table class="payslip__table">
        <thead>
          <tr><th>Earnings</th><th>Amount</th></tr>
        </thead>
        <tbody>
          <tr>
            <td>Basic</td>
            <td><input id="payslip-basic" class="payslip__table-input" type="number" value="0"></td>
          </tr>
          <tr>
            <td>House Rent Allowance</td>
            <td><input id="payslip-hra" class="payslip__table-input" type="number" value="0"></td>
          </tr>
          <tr class="payslip__row-total">
            <td><strong>Gross Earnings:</strong></td>
            <td id="payslip-gross">0.00</td>
          </tr>
        </tbody>
      </table>

      <!-- Deductions Table -->
      <table class="payslip__table">
        <thead>
          <tr><th>Deductions</th><th>Amount</th></tr>
        </thead>
        <tbody>
          <tr>
            <td>Income Tax</td>
            <td><input id="payslip-tax" class="payslip__table-input" type="number" value="0"></td>
          </tr>
          <tr>
            <td>Provident Fund</td>
            <td><input id="payslip-pf" class="payslip__table-input" type="number" value="0"></td>
          </tr>
          <tr class="payslip__row-total">
            <td><strong>Total Deductions:</strong></td>
            <td id="payslip-total-deduction">0.00</td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>


  <!-- Net Pay -->
  <div class="payslip__summary">
    <div class="payslip__summary-left">
      <strong>Total Net Payable</strong><br>
      <span class="payslip__summary-note">Gross Earnings - Total Deductions</span>
    </div>
    <div class="payslip__summary-right" id="payslip-net">0.00</div>
  </div>

  <div class="payslip__words">
    Amount in words: <span id="payslip-words">Zero</span>
  </div>


  <!-- Buttons -->
  <div class="payslip__actions">
    <button id="payslip-generate" class="payslip__btn payslip__btn--primary btn">Generate Payslip</button>
    <button id="payslip-reset" class="payslip__btn payslip__btn--ghost">Reset</button>
  </div>
  <div id="payslip-error-message" style="color: red; margin-top: 10px; font-weight: 500; text-align:center"></div>

  <!-- PRINT TEMPLATE -->
<div id="payslip-print" style="display:none; padding:20px; font-family:Arial; width:700px;">
    
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <img id="print-logo" style="height:60px;">
    <h2 id="print-month"></h2>
  </div>

  <div style="margin-bottom:20px;">
  <h3 id="print-company-name" style="margin:0;"></h3>
  <p id="print-company-address" style="margin:2px 0;"></p>
  <p id="print-company-location" style="margin:2px 0;"></p>
  </div>
  <table style="width:100%; border-collapse: collapse; margin-bottom:20px;">
    <tr><td><strong>Employee Name:</strong></td><td id="print-name"></td></tr>
    <tr><td><strong>Employee ID:</strong></td><td id="print-id"></td></tr>
    <tr><td><strong>Pay Period:</strong></td><td id="print-period"></td></tr>
    <tr><td><strong>Paid Days:</strong></td><td id="print-paid"></td></tr>
    <tr><td><strong>Loss of Pay Days:</strong></td><td id="print-loss"></td></tr>
    <tr><td><strong>Pay Date:</strong></td><td id="print-date"></td></tr>
  </table>

  <table style="width:100%; border-collapse: collapse; margin-bottom:20px; font-size:14px;">
    <thead>
      <tr><th>Earnings</th><th>Amount (Rs.)</th><th>Deductions</th><th>Amount (Rs.)</th></tr>
    </thead>
    <tbody>
      <tr>
        <td>Basic</td><td id="print-basic"></td>
        <td>Income Tax</td><td id="print-tax"></td>
      </tr>
      <tr>
        <td>House Rent Allowance</td><td id="print-hra"></td>
        <td>Provident Fund</td><td id="print-pf"></td>
      </tr>
      <tr style="font-weight:bold;">
        <td>Gross Earnings:</td><td id="print-gross"></td>
        <td>Total Deductions:</td><td id="print-deduct"></td>
      </tr>
    </tbody>
  </table>

  <h3>Net Salary Payable: <span id="print-net"></span></h3>
  <p>In words: <span id="print-words"></span> Only</p>

  <p style="margin-top:30px; font-size:12px; color:#555;">
    This is a system-generated payslip and does not require a signature.
  </p>

</div>


</div>

   

    <?php }
 


  
   

// ===============================
// ===============================
// Invoice Generator
// ===============================
// ===============================
if ($atts['type'] === 'invoice') { ?>

<div class="invoice-generator-wrapper">
  <div class="invoice-paper" id="invoice-paper">
    <div class="inv-header">
       <div class="inv-logo-box">
          <label for="inv-logo" class="inv-logo-label no-print" id="inv-logo-label-box">
            <span id="inv-logo-text">+ Add Your Logo</span>
          </label>
          <img id="inv-logo-preview" style="display:none; max-height:80px; max-width:150px;"/>
          <input type="file" id="inv-logo" accept="image/*" hidden>
       </div>
       <div class="inv-title-box">
          <input type="text" id="inv-title" value="TAX INVOICE" class="inv-input-h1">
       </div>
    </div>

    <div class="inv-body">
       <div class="inv-row" style="display: flex; justify-content: space-between;">
          <div class="inv-col-half">
            <input type="text" id="inv-company-name" placeholder="Your Company" class="inv-input inv-input-bold">
            <input type="text" id="inv-company-name-person" placeholder="Your Name" class="inv-input">
            <input type="email" id="inv-company-email" placeholder="Your Email" class="inv-input">
            <input type="text" id="inv-company-gst" placeholder="Company's GSTIN" class="inv-input">
            <input type="text" id="inv-company-address" placeholder="Company's Address" class="inv-input">
            <input type="text" id="inv-company-city" placeholder="City" class="inv-input">
            <input type="text" id="inv-company-state" placeholder="State" class="inv-input">
            <input type="text" id="inv-company-country" placeholder="Country" value="India" class="inv-input">
          </div>
          <div class="inv-col-half" style="text-align: right;">
          </div>
       </div>

       <div class="inv-row" style="margin-top: 40px; display: flex; justify-content: space-between;">
          <div class="inv-col-half">
            <div class="inv-label">Bill To:</div>
            <input type="text" id="inv-client-company" placeholder="Client's Company" class="inv-input inv-input-bold">
            <input type="email" id="inv-client-email" placeholder="Client's Email" class="inv-input">
            <input type="text" id="inv-client-gst" placeholder="Client's GSTIN" class="inv-input">
            <input type="text" id="inv-client-address" placeholder="Client's Address" class="inv-input">
            <input type="text" id="inv-client-city" placeholder="City" class="inv-input">
            <input type="text" id="inv-client-state" placeholder="State" class="inv-input">
            <input type="text" id="inv-client-country" placeholder="Country" value="India" class="inv-input">
            <input type="text" id="inv-place-supply" placeholder="Place of Supply" class="inv-input">
          </div>
          <div class="inv-col-half" style="max-width: 250px;">
             <div class="inv-meta-row">
                <span class="inv-label">Invoice#</span>
                <input type="text" id="inv-number" placeholder="INV-1" class="inv-input meta-input" style="text-align: right;">
             </div>
             <div class="inv-meta-row">
                <span class="inv-label">Invoice Date</span>
                <input type="date" id="inv-date" class="inv-input meta-input" style="text-align: right;">
             </div>
             <div class="inv-meta-row">
                <span class="inv-label">Due Date</span>
                <input type="date" id="inv-due-date" class="inv-input meta-input" style="text-align: right;">
             </div>
          </div>
       </div>

       <div class="inv-items-wrapper">
          <table class="inv-table">
            <thead>
              <tr class="inv-table-header">
                <th width="26%" style="text-align:center;">Item Description</th>
                <th width="8%" style="text-align:center">Qty</th>
                <th width="14%" style="text-align:center">Rate</th>
                <th width="11%" style="text-align:center">SGST(%)</th>
                <th width="11%" style="text-align:center">CGST(%)</th>
                <th width="11%" style="text-align:center">Cess</th>
                <th width="15%" style="text-align:center;">Amount</th>
                <th width="4%" class="no-print"></th>
              </tr>
            </thead>
            <tbody id="inv-items-body">
            </tbody>
          </table>
          <button id="inv-add-item" class="inv-add-btn no-print">+ Add Line Item</button>
       </div>

       <div class="inv-row" style="margin-top: 40px; display: flex; justify-content: space-between;">
          <div class="inv-col-half" style="width: 50%;">
             <div class="inv-notes-box">
                <div class="inv-label">Notes</div>
                <textarea id="inv-notes" class="inv-textarea" placeholder="It was great doing business with you."></textarea>
             </div>
             <div class="inv-notes-box" style="margin-top: 20px;">
                <div class="inv-label">Terms & Conditions</div>
                <textarea id="inv-terms" class="inv-textarea" placeholder="Please make the payment by the due date."></textarea>
             </div>
          </div>
          <div class="inv-col-half" style="width: 40%;">
             <div class="inv-totals-box">
                <div class="inv-total-row">
                   <span>Sub Total</span>
                   <span id="inv-subtotal">0.00</span>
                </div>
                <div class="inv-total-row">
                   <span>SGST</span>
                   <span id="inv-sgst-total">0.00</span>
                </div>
                <div class="inv-total-row">
                   <span>CGST</span>
                   <span id="inv-cgst-total">0.00</span>
                </div>
                <div class="inv-total-row inv-total-grand">
                   <span>Total</span>
                   <div style="display: flex; align-items: center;">
                      <select id="inv-currency" class="inv-input no-print" style="width: auto; padding: 0px 5px; margin-right: 5px; font-weight: 700; background: transparent; border: 1px solid transparent; font-size: 16px; cursor: pointer;">
                        <option value="₹">₹</option>
                        <option value="$">$</option>
                        <option value="€">€</option>
                        <option value="£">£</option>
                        <option value="A$">A$</option>
                        <option value="C$">C$</option>
                        <option value="¥">¥</option>
                        <option value="S$">S$</option>
                        <option value="AED">AED</option>
                      </select>
                      <span id="inv-grand-total">0.00</span>
                   </div>
                </div>
             </div>
          </div>
       </div>

    </div>
  </div>
  
  <div class="inv-actions no-print">
     <button id="inv-print-btn" class="button button--ghost" style="padding: 15px 30px; font-size: 18px;">Download Invoice PDF</button>
  </div>
</div>

<?php }



// ===============================
// ===============================
// IN HAND SALARY CALCULATOR
// ===============================
// ===============================

if ($atts['type'] === 'in-hand-salary') { ?>

    <div class="salary-calculator-wrapper">
        <!-- Title & Subtitle Header -->
        <!-- <div class="salary-calculator-header">
            <h1 class="salary-title">Salary Calculator</h1>
            <p class="salary-subtitle">Calculate new joinee salary, revised salary after performance cycle and more with
                <b>Weekmate’s</b> free salary calculator</p>
        </div> -->

        <!-- Dashed Outer Container -->
        <div class="salary-calculator-box">

            <!-- Upper Section (White Background) -->
            <div class="salary-upper-section">

                <!-- Upper Left: Main Form Inputs -->
                <div class="salary-upper-left">
                    <h2 class="salary-section-title">CALCULATE YOUR IN-HAND SALARY</h2>

                    <!-- Cost to Company (CTC) -->
                    <div class="salary-form-group">
                        <label for="salary-ctc" class="salary-floating-label">Cost to Company (CTC)<span
                                class="salary-asterisk">*</span></label>
                        <div class="salary-input-wrapper">
                            <span class="salary-currency-symbol">₹</span>
                            <input type="number" id="salary-ctc" class="salary-input" placeholder="0" min="0"
                                step="any">
                        </div>
                    </div>

                    <!-- Total Bonus included in CTC -->
                    <div class="salary-form-group">
                        <label for="salary-bonus-type" class="salary-floating-label">Total Bonus included in CTC <span
                                class="salary-asterisk">*</span></label>
                        <div class="salary-select-wrapper">
                            <select id="salary-bonus-type" class="salary-select">
                                <option value="amount" selected>Amount</option>
                                <option value="percentage">Percentage</option>
                            </select>
                            <span class="salary-select-chevron">&#x25BE;</span>
                        </div>
                    </div>

                    <!-- Bonus Amount / Percentage -->
                    <div class="salary-form-group">
                        <label for="salary-bonus-amount" id="salary-bonus-label" class="salary-floating-label">Bonus
                            Amount<span class="salary-asterisk">*</span></label>
                        <div class="salary-input-wrapper">
                            <span id="salary-bonus-symbol" class="salary-currency-symbol">₹</span>
                            <input type="number" id="salary-bonus-amount" class="salary-input" placeholder="0" min="0"
                                step="any">
                        </div>
                    </div>

                    <!-- Employee PF -->
                    <div class="salary-form-group">
                        <label for="salary-employee-pf" class="salary-floating-label">Monthly Employee PF<span
                                class="salary-asterisk">*</span></label>
                        <div class="salary-input-wrapper">
                            <span class="salary-currency-symbol">₹</span>
                            <input type="number" id="salary-employee-pf" class="salary-input" placeholder="0" min="0"
                                step="any">
                        </div>
                    </div>
                </div>

                <!-- Upper Right: Result Summary Blocks + Decorative SVG -->
                <div class="salary-upper-right">
                    <div class="salary-results-list">
                        <div class="salary-result-row">
                            <span class="salary-result-label">Net take home annual</span>
                            <span id="salary-result-net-annual" class="salary-result-value">₹ 0.00</span>
                        </div>
                        <div class="salary-result-row">
                            <span class="salary-result-label">Net take home monthly</span>
                            <span id="salary-result-net-monthly" class="salary-result-value">₹ 0.00</span>
                        </div>
                        <div class="salary-result-row">
                            <span class="salary-result-label">Total Annual Deductions</span>
                            <span id="salary-result-deductions-annual" class="salary-result-value">₹ 0.00</span>
                        </div>
                        <div class="salary-result-row">
                            <span class="salary-result-label">Total Monthly Deductions</span>
                            <span id="salary-result-deductions-monthly" class="salary-result-value">₹ 0.00</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Lower Section (Pale Yellow Background Panel) -->
            <div class="salary-lower-section">

                <!-- Lower Left: Monthly Deductions Inputs -->
                <div class="salary-lower-left">
                    <div class="salary-accordion-header">
                        <span class="salary-accordion-title">Monthly Deductions</span>
                        <span class="salary-accordion-icon">&#x2303;</span>
                    </div>

                    <div class="salary-deductions-inputs">
                        <!-- Employer PF -->
                        <div class="salary-form-group">
                            <label for="salary-employer-pf" class="salary-floating-label">Employer PF<span
                                    class="salary-asterisk">*</span></label>
                            <div class="salary-input-wrapper">
                                <span class="salary-currency-symbol">₹</span>
                                <input type="number" id="salary-employer-pf" class="salary-input" placeholder="0"
                                    min="0" step="any">
                            </div>
                        </div>

                        <!-- Professional Tax -->
                        <div class="salary-form-group">
                            <label for="salary-professional-tax" class="salary-floating-label">Professional tax<span
                                    class="salary-asterisk">*</span></label>
                            <div class="salary-input-wrapper">
                                <span class="salary-currency-symbol">₹</span>
                                <input type="number" id="salary-professional-tax" class="salary-input" placeholder="0"
                                    min="0" step="any">
                            </div>
                        </div>

                        <!-- Employee Insurance -->
                        <div class="salary-form-group">
                            <label for="salary-employee-insurance" class="salary-floating-label">Employee Insurance<span
                                    class="salary-asterisk">*</span></label>
                            <div class="salary-input-wrapper">
                                <span class="salary-currency-symbol">₹</span>
                                <input type="number" id="salary-employee-insurance" class="salary-input" placeholder="0"
                                    min="0" step="any">
                            </div>
                        </div>

                        <!-- Additional Deduction -->
                        <div class="salary-form-group">
                            <label for="salary-additional-deduction" class="salary-floating-label">Additional
                                Deduction<span class="salary-asterisk">*</span></label>
                            <div class="salary-input-wrapper">
                                <span class="salary-currency-symbol">₹</span>
                                <input type="number" id="salary-additional-deduction" class="salary-input"
                                    placeholder="0" min="0" step="any">
                            </div>
                        </div>
                    </div>

                    <!-- Calculate Button -->
                    <button type="button" id="salary-calculate-btn" class="side-btn btn btn-primary mt-3">Calculate Your
                        Instantly</button>
                </div>

                <!-- Lower Right: ApexCharts Distribution Chart -->
                <div class="salary-lower-right">
                    <div class="salary-chart-card">
                        <div id="salary-apex-chart"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php }


// ===============================
// ===============================
// Commission Calculator
// ===============================
// ===============================

if ($atts['type'] === 'sales-commision-calculator') { ?>
      <!-- Main Calculator Container -->
  <div class="calculator-wrapper">
    <div class="calculator-grid">
      <!-- Left Column: Inputs -->
      <section class="calc-card">
        <h2 class="column-title">Commission Calculator</h2>

        <!-- Total Sales Amount Input -->
        <div class="form-group">
          <label for="sales-input" class="form-label">
            Total Sales Amount: <span id="sales-label-val">₹10,000</span>
          </label>
          <input type="number" id="sales-input" class="form-input" value="10000" min="0" max="100000" step="1">
          <div class="range-container">
            <input type="range" id="sales-slider" class="range-input" value="10000" min="0" max="100000" step="500">
            <div class="range-labels">
              <span>₹0</span>
              <span>₹100K</span>
            </div>
          </div>
        </div>

        <!-- Commission Structure Dropdown -->
        <div class="form-group">
          <label for="structure-select" class="form-label">Commission Structure</label>
          <div class="select-wrapper">
            <select id="structure-select" class="form-select">
              <option value="percentage" selected>Percentage-based</option>
              <option value="flat">Flat Rate</option>
            </select>
          </div>
        </div>

        <!-- Tiered Structure Checkbox -->
        <div class="form-group checkbox-group">
          <label for="tiered-checkbox" class="checkbox-label">
            <input type="checkbox" id="tiered-checkbox" class="checkbox-input">
            <span class="checkbox-text">Use Tiered Commission Structure</span>
          </label>
        </div>

        <!-- Standard Commission Rate Input (hidden when Tiered is checked) -->
        <div class="form-group" id="rate-group">
          <label for="rate-input" class="form-label" id="rate-label">
            Commission Rate: <span id="rate-label-val">5%</span>
          </label>
          <input type="number" id="rate-input" class="form-input" value="5" min="0" max="100" step="0.1">
          <div class="range-container">
            <input type="range" id="rate-slider" class="range-input" value="5" min="0" max="100" step="0.1">
            <div class="range-labels">
              <span id="rate-slider-min">0%</span>
              <span id="rate-slider-max">100%</span>
            </div>
          </div>
        </div>

        <!-- Tiered Commission Rates Box (shown when Tiered is checked) -->
        <div id="tiered-rates-card" class="tiered-card" style="display: none;">
          <h3 class="tiered-card-title">Tiered Commission Rates</h3>
          <div class="tiered-grid">
            <div class="form-group mini-group">
              <label for="tier1-threshold" class="form-label mini-label">Tier 1 Threshold</label>
              <input type="number" id="tier1-threshold" class="form-input" value="5000" min="0" step="100">
            </div>
            <div class="form-group mini-group">
              <label for="tier1-rate" class="form-label mini-label">Tier 1 Rate (%)</label>
              <input type="number" id="tier1-rate" class="form-input" value="3" min="0" max="100" step="0.1">
            </div>
            <div class="form-group mini-group">
              <label for="tier2-threshold" class="form-label mini-label">Tier 2 Threshold</label>
              <input type="number" id="tier2-threshold" class="form-input" value="10000" min="0" step="100">
            </div>
            <div class="form-group mini-group">
              <label for="tier2-rate" class="form-label mini-label">Tier 2 Rate (%)</label>
              <input type="number" id="tier2-rate" class="form-input" value="5" min="0" max="100" step="0.1">
            </div>
            <div class="form-group mini-group">
              <label for="tier3-rate" class="form-label mini-label">Tier 3+ Rate (%)</label>
              <input type="number" id="tier3-rate" class="form-input" value="7" min="0" max="100" step="0.1">
            </div>
            <div class="tiered-subtext-container">
              <span id="tier3-above-text" class="tiered-subtext">For sales above ₹10,000</span>
            </div>
          </div>
        </div>
      </section>

      <!-- Right Column: Results -->
      <section class="results-card">
        <h2 class="column-title">Commission Results</h2>

        <!-- Result 1: Total Commission -->
        <div class="result-box box-blue">
          <div class="box-label">Total Commission</div>
          <div class="box-value value-primary" id="res-total-commission">₹500.00</div>
          <div class="box-subtext subtext-primary" id="res-commission-percent">5.0% of sales</div>
        </div>

        <!-- Result 2: Effective Rate -->
        <div class="result-box box-blue">
          <div class="box-label">Effective Commission Rate</div>
          <div class="box-value value-dark" id="res-effective-rate">5.00%</div>
          <div class="box-subtext subtext-muted">Average commission rate</div>
        </div>

        <!-- Result 3: Remaining Revenue -->
        <div class="result-box box-green">
          <div class="box-label label-green">Remaining Revenue</div>
          <div class="box-value value-green" id="res-remaining-revenue">₹9,500</div>
          <div class="box-subtext subtext-green">After commission deduction</div>
        </div>

        <!-- Result 4: Commission Breakdown (Tiered mode only) -->
        <div class="result-box box-white" id="res-breakdown-box" style="display: none;">
          <h3 class="breakdown-title">Commission Breakdown</h3>
          <div id="breakdown-rows-container">
            <!-- Dynamic breakdown rows inserted via JS -->
          </div>
        </div>

        <!-- Result 5: Commission Insights -->
        <div class="result-box box-grey">
          <h3 class="insight-title">Commission Insights</h3>
          <p class="insight-line">Consider if this rate aligns with industry standards</p>
          <p class="insight-line" id="res-insight-sales">Commission represents 5.0% of total sales</p>
          <p class="insight-line" id="res-insight-tiered" style="display: none;">Tiered structure incentivizes higher sales volumes</p>
        </div>
      </section>
    </div>
  </div>
 
<?php }



// ===============================
// ===============================
// Project Cost Calculator
// ===============================
// ===============================

if ($atts['type'] === 'project-cost-calculator') { ?>
  <div class="projectCost-page-container">

    <!-- Calculator Card -->
    <section class="projectCost-calculator-card" aria-label="Project Cost Calculator Form">
      <!-- Card Top Dark Blue Bar -->
      <div class="projectCost-card-header">
        <h2 class="projectCost-card-title">Project Cost Calculator</h2>
      </div>

      <!-- Card Body Form -->
      <form id="projectCost-calculator-form" class="projectCost-card-body" onsubmit="return false;">
        <!-- Project Type Field -->
        <div class="projectCost-form-group">
          <label for="projectCost-project-type" class="projectCost-form-label">Project Type</label>
          <div class="projectCost-select-wrapper">
            <select id="projectCost-project-type" name="projectCost-projectType" class="projectCost-form-select">
              <option value="standard" selected>Standard Website</option>
              <option value="ecommerce">E-Commerce Website</option>
              <option value="webapp">Web Application</option>
              <option value="landing">Landing Page</option>
              <option value="enterprise">Enterprise Solution</option>
            </select>
            <span class="projectCost-select-arrow" aria-hidden="true">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
              </svg>
            </span>
          </div>
        </div>

        <!-- Number of Pages / Screens Slider -->
        <div class="projectCost-form-group">
          <div class="projectCost-slider-header">
            <label for="projectCost-pages-slider" class="projectCost-form-label projectCost-slider-label">
              Number of Pages / Screens: <span id="projectCost-pages-count-display" class="projectCost-highlight-count">21</span>
            </label>
          </div>
          <div class="projectCost-slider-wrapper">
            <input 
              type="range" 
              id="projectCost-pages-slider" 
              name="projectCost-pagesCount" 
              min="1" 
              max="50" 
              value="21" 
              class="projectCost-range-slider"
              aria-valuemin="1"
              aria-valuemax="50"
              aria-valuenow="21"
              aria-label="Number of Pages or Screens"
            >
          </div>
        </div>

        <!-- Design Complexity Radio Group -->
        <div class="projectCost-form-group">
          <span class="projectCost-form-label projectCost-group-label">Design Complexity</span>
          <div class="projectCost-radio-group" role="radiogroup" aria-label="Design Complexity">
            <label class="projectCost-radio-label">
              <input type="radio" name="projectCost-designComplexity" value="simple" class="projectCost-custom-radio" checked>
              <span class="projectCost-radio-indicator"></span>
              <span class="projectCost-radio-text">Simple</span>
            </label>
            <label class="projectCost-radio-label">
              <input type="radio" name="projectCost-designComplexity" value="standard" class="projectCost-custom-radio">
              <span class="projectCost-radio-indicator"></span>
              <span class="projectCost-radio-text">Standard</span>
            </label>
            <label class="projectCost-radio-label">
              <input type="radio" name="projectCost-designComplexity" value="highend" class="projectCost-custom-radio">
              <span class="projectCost-radio-indicator"></span>
              <span class="projectCost-radio-text">High-End</span>
            </label>
          </div>
        </div>

        <!-- Additional Features Checkbox Group -->
        <div class="projectCost-form-group">
          <span class="projectCost-form-label projectCost-group-label">Additional Features</span>
          <div class="projectCost-checkbox-group" aria-label="Additional Features">
            <label class="projectCost-checkbox-label">
              <input type="checkbox" id="projectCost-feature-cms" name="projectCost-features" value="cms" class="projectCost-custom-checkbox" checked>
              <span class="projectCost-checkbox-indicator">
                <svg class="projectCost-check-icon" width="12" height="12" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="2.5 7 5.5 10 11.5 3.5"></polyline>
                </svg>
              </span>
              <span class="projectCost-checkbox-text">Content Management System (CMS)</span>
            </label>

            <label class="projectCost-checkbox-label">
              <input type="checkbox" id="projectCost-feature-seo" name="projectCost-features" value="seo" class="projectCost-custom-checkbox" checked>
              <span class="projectCost-checkbox-indicator">
                <svg class="projectCost-check-icon" width="12" height="12" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="2.5 7 5.5 10 11.5 3.5"></polyline>
                </svg>
              </span>
              <span class="projectCost-checkbox-text">SEO Optimization</span>
            </label>

            <label class="projectCost-checkbox-label">
              <input type="checkbox" id="projectCost-feature-auth" name="projectCost-features" value="auth" class="projectCost-custom-checkbox">
              <span class="projectCost-checkbox-indicator">
                <svg class="projectCost-check-icon" width="12" height="12" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="2.5 7 5.5 10 11.5 3.5"></polyline>
                </svg>
              </span>
              <span class="projectCost-checkbox-text">User Authentication</span>
            </label>
          </div>
        </div>

        <!-- Divider Line -->
        <hr class="projectCost-card-divider" />

        <!-- Cost Estimation Output Section -->
        <div class="projectCost-cost-output-section" aria-live="polite">
          <p class="projectCost-cost-label">Estimated Project Cost</p>
          <div id="projectCost-cost-display" class="projectCost-cost-amount" aria-label="Estimated Cost: ₹5,950">₹5,950</div>
        </div>

        <!-- Actions -->
        <div class="projectCost-card-actions">
          <!-- <button type="button" id="projectCost-calculate-btn" class="projectCost-btn-calculate" aria-label="Calculate Cost">
            Calculate Cost
          </button> -->
          <button type="button" id="projectCost-reset-btn" class="projectCost-btn-reset" aria-label="Reset Calculator">
            Reset Calculator
          </button>
        </div>
      </form>
    </section>
  </div>

<?php }





    return ob_get_clean();
}

add_shortcode('calculator', 'weekmate_calculator_shortcode');
