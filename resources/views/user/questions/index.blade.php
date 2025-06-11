@extends('layouts.user')

@section('title')
    Lab x Lap - Questionnaire
@endsection

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&family=Special+Elite&display=swap" rel="stylesheet">
<style>
    body {
        font-family: "Roboto Mono", monospace;
        background-color: #f3f1f0;
        color: #6b6b6b;
    }

    /* Custom input styling */
    input[type="text"] {
        background: transparent;
        border: none;
        border-bottom: 1px solid #6b6b6b;
        outline: none;
        font-family: "Roboto Mono", monospace;
        font-size: 1.25rem;
        color: #6b6b6b;
        padding: 0.125rem 0;
        width: 16rem;
    }

    input[type="text"]::placeholder {
        color: transparent;
    }

    /* Custom select styling */
    select {
        font-family: "Roboto Mono", monospace;
        font-size: 1.25rem;
        color: #6b6b6b;
        background: transparent;
        border: none;
        padding: 0;
        margin: 0;
        outline: none;
        box-shadow: none;
        cursor: pointer;
        width: 100%;
    }

    select option {
        background: #f3f1f0;
        color: #3a3a3a;
        font-family: "Roboto Mono", monospace;
        font-size: 1.25rem;
        padding: 0.5rem;
        white-space: normal;
        word-wrap: break-word;
    }

    select option:checked {
        background-color: #6b6b6b;
        color: #f3f1f0;
    }

    /* Step transition */
    .step {
        display: none;
    }

    .step.active {
        display: block;
    }

    /* Checkbox and radio styling */
    .option-label {
        cursor: pointer;
        user-select: none;
        transition: all 0.2s ease;
    }

    .option-label:hover {
        opacity: 0.8;
    }

    /* Arrow styling */
    .arrow-next {
        cursor: pointer;
        transition: transform 0.2s;
    }

    .arrow-next:hover {
        transform: scale(1.1);
    }

    .arrow-next svg {
        width: 60px;
        height: 60px;
    }

    .arrow-disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .arrow-disabled:hover {
        transform: none;
    }

    /* Spec option styling */
    .spec-option {
        border: 1px solid #b7b7b7;
        cursor: pointer;
        transition: all 0.2s ease;
        background: transparent;
    }

    .spec-option:hover {
        background-color: #e0e0e0;
    }

    .spec-option.selected {
        background-color: #5a5858;
        color: #f0eeec;
        border-color: #5a5858;
    }

    /* Question styling */
    .question-title {
        font-family: "Roboto Mono", monospace;
        font-size: 2.5rem;
        line-height: 1.2;
        color: #4a4a4a;
        margin-bottom: 2.5rem;
    }

    /* Option styling */
    .option-label {
        font-family: "Roboto Mono", monospace;
        font-size: 1.25rem;
        padding: 1rem 1.5rem;
    }

    /* Spec option styling */
    .spec-option {
        font-family: "Roboto Mono", monospace;
        font-size: 1.25rem;
        padding: 1rem 1.5rem;
    }

    /* Container styling */
    .question-container {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        padding: 2rem 4rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Section styling */
    .question-section {
        max-width: 500px;
        margin: 0 auto;
    }

    /* Form styling */
    .form-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 200px);
    }

    /* Bio form styling */
    .bio-form {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        max-width: 1000px;
        margin: 0 auto;
        gap: 4rem;
    }

    .bio-title {
        flex: 0 0 300px;
    }

    .bio-inputs {
        flex: 0 0 500px;
    }

    /* Specs container styling */
    .specs-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 200px);
        gap: 4rem;
    }

    /* Specs title styling */
    .specs-title {
        flex: 0 0 300px;
    }

    /* Specs options styling */
    .specs-options {
        flex: 0 0 auto;
        display: flex;
        gap: 4rem;
    }

    /* Header styling */
    .question-header {
        font-size: 1.25rem;
        margin-bottom: 3rem;
    }
</style>
@endsection

@section('content')
<div class="min-h-screen flex flex-col">
    <!-- Step 1: Bio Data -->
    <div id="step1" class="step active">
        <div class="form-container">
            <div class="bio-form">
                <div class="bio-title">
                    <h1 class="text-[5rem] font-normal leading-[4.5rem] text-[#6b6b6b] select-none">
                        BIO<br/>DATA
                    </h1>
                </div>
                
                <div class="bio-inputs">
                    <form class="flex flex-col space-y-8 text-[#6b6b6b] font-normal leading-tight" id="bioForm">
                        <div class="flex items-center space-x-6">
                            <label class="w-32 select-none text-xl" for="name">
                                Nama
                            </label>
                            <input autocomplete="off" id="name" name="name" type="text" required/>
                        </div>
                        
                        <div class="flex items-start space-x-6">
                            <label class="w-32 select-none pt-1 text-xl" for="program">
                                Program Studi
                            </label>
                            <div class="flex flex-col space-y-1">
                                <select class="w-[400px] cursor-pointer" id="program" name="program" size="3" required>
                                    <option value="Teknik Informatika">Teknik Informatika</option>
                                    <option value="Teknik Multimedia Digital">Teknik Multimedia Digital</option>
                                    <option value="Teknik Multimedia Jaringan">Teknik Multimedia Jaringan</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <footer class="flex justify-end px-12 py-4">
            <div class="arrow-next" onclick="nextStep(1)" id="arrow1">
                <svg width="60" height="60" viewBox="0 0 40 40" class="text-[#6b6b6b]">
                    <path d="M15 12l8 8-8 8" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" transform="rotate(45 20 20)"/>
                </svg>
            </div>
        </footer>
    </div>

    <!-- Step 2: Questions -->
    <div id="step2" class="step">
        <div class="question-container">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:flex-grow gap-10 sm:gap-20 mb-12">
                <div class="text-xl font-normal text-[#7a7a7a]">1</div>
                <div class="text-xl font-normal text-[#7a7a7a] text-right">Kebutuhan &amp; Preferensi</div>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-center sm:items-start gap-16 sm:gap-32">
                <!-- Activities Section -->
                <section class="question-section">
                    <h2 class="question-title">
                        Apa kegiatan utama yang<br />
                        kamu lakukan yang<br />
                        menggunakan laptop?
                    </h2>
                    
                    <form class="flex flex-col gap-3" id="activitiesForm">
                        <div class="text-sm text-red-600 mb-2" id="activityWarning" style="display: none;">
                            Anda hanya dapat memilih maksimal 3 kegiatan
                        </div>
                        <label class="option-label inline-flex items-center gap-3 bg-[#d9d9d9] text-[#4a4a4a] w-max">
                            <input type="checkbox" name="activity" value="programming" class="w-5 h-5 activity-checkbox" />
                            Programming/Coding
                        </label>
                        <label class="option-label inline-flex items-center gap-3 bg-[#d9d9d9] text-[#4a4a4a] w-max">
                            <input type="checkbox" name="activity" value="desain" class="w-5 h-5" />
                            Desain Grafis/Multimedia
                        </label>
                        <label class="option-label inline-flex items-center gap-3 bg-[#d9d9d9] text-[#4a4a4a] w-max">
                            <input type="checkbox" name="activity" value="machine-learning" class="w-5 h-5" />
                            Machine Learning/AI
                        </label>
                        <label class="option-label inline-flex items-center gap-3 bg-[#d9d9d9] text-[#4a4a4a] w-max">
                            <input type="checkbox" name="activity" value="game-dev" class="w-5 h-5" />
                            Pengembangan Game
                        </label>
                        <label class="option-label inline-flex items-center gap-3 bg-[#d9d9d9] text-[#4a4a4a] w-max">
                            <input type="checkbox" name="activity" value="office" class="w-5 h-5" />
                            Office/Produktivitas
                        </label>
                        <label class="option-label inline-flex items-center gap-3 bg-[#d9d9d9] text-[#4a4a4a] w-max">
                            <input type="checkbox" name="activity" value="network" class="w-5 h-5" />
                            Network Configurating
                        </label>
                        <label class="option-label inline-flex items-center gap-3 bg-[#d9d9d9] text-[#4a4a4a] w-max">
                            <input type="checkbox" name="activity" value="database" class="w-5 h-5" />
                            Database
                        </label>
                    </form>
                </section>

                <!-- Budget Section -->
                <section class="question-section">
                    <h2 class="question-title">
                        Berapa <em>budget</em> ideal untuk<br />
                        laptop mahasiswa TIK<br />
                        menurut kamu?
                    </h2>
                    
                    <form class="flex flex-col gap-3" id="budgetForm">
                        <label class="option-label inline-flex items-center gap-3 bg-[#d9d9d9] w-max">
                            <input type="radio" name="budget" value="less-5m" class="w-5 h-5" />
                            &lt; Rp5.000.000
                        </label>
                        <label class="option-label inline-flex items-center gap-3 bg-[#e6e6e6] w-max">
                            <input type="radio" name="budget" value="5m-8m" class="w-5 h-5" />
                            Rp5.000.000 - 8.000.000
                        </label>
                        <label class="option-label inline-flex items-center gap-3 bg-[#d9d9d9] w-max">
                            <input type="radio" name="budget" value="8m-12m" class="w-5 h-5" />
                            Rp8.000.000 - 12.000.000
                        </label>
                        <label class="option-label inline-flex items-center gap-3 bg-[#e6e6e6] w-max">
                            <input type="radio" name="budget" value="12m-15m" class="w-5 h-5" />
                            Rp12.000.000 - 15.000.000
                        </label>
                        <label class="option-label inline-flex items-center gap-3 bg-[#d9d9d9] w-max">
                            <input type="radio" name="budget" value="more-15m" class="w-5 h-5" />
                            &gt;Rp15.000.000
                        </label>
                    </form>
                </section>
            </div>
        </div>

        <footer class="flex justify-between items-center w-full max-w-full mx-auto mt-12 px-12">
            <!-- Back Arrow -->
            <div class="arrow-next" onclick="prevStep(1)">
                <svg width="60" height="60" viewBox="0 0 40 40" class="text-[#7a7a7a]">
                    <path d="M25 12l-8 8 8 8" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" transform="rotate(-45 20 20)"/>
                </svg>
            </div>

            <!-- Next Arrow -->
            <div class="arrow-next" onclick="nextStep(2)" id="arrow2">
                <svg width="60" height="60" viewBox="0 0 40 40" class="text-[#7a7a7a]">
                    <path d="M15 12l8 8-8 8" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" transform="rotate(45 20 20)"/>
                </svg>
            </div>
        </footer>
    </div>

    <!-- Step 3: RAM & Storage -->
    <div id="step3" class="step">
        <div class="question-container">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:flex-grow gap-10 sm:gap-20 mb-12">
                <div class="text-xl font-normal text-[#7a7a7a]">1</div>
                <div class="text-xl font-normal text-[#7a7a7a] text-right">Kebutuhan &amp; Preferensi</div>
            </div>
            
            <div class="specs-container">
                <!-- Title Section -->
                <div class="specs-title">
                    <div class="leading-none">
                        <div class="text-xl mb-2 text-[#5a5858]">Spesifikasi</div>
                        <div class="text-[48px] font-light leading-[1] text-[#5a5858]">
                            RAM &<br />
                            PENYIM<br />
                            PANAN
                        </div>
                    </div>
                </div>
                
                <!-- Options Section -->
                <div class="specs-options">
                    <!-- RAM Section -->
                    <div>
                        <div class="text-2xl underline mb-8 font-light text-[#5a5858]">RAM</div>
                        <div class="space-y-4" id="ramOptions">
                            <div class="spec-option w-[160px]" data-type="ram" data-value="4gb">4 GB</div>
                            <div class="spec-option w-[160px]" data-type="ram" data-value="8gb">8 GB</div>
                            <div class="spec-option w-[160px]" data-type="ram" data-value="16gb">16 GB</div>
                            <div class="spec-option w-[200px]" data-type="ram" data-value="32gb">32 GB/Lebih</div>
                        </div>
                    </div>
                    
                    <!-- Storage Section -->
                    <div>
                        <div class="text-2xl underline mb-8 font-light text-[#5a5858]">Penyimpanan</div>
                        <div class="space-y-4" id="storageOptions">
                            <div class="spec-option w-[200px]" data-type="storage" data-value="hdd-500gb">HDD 500GB</div>
                            <div class="spec-option w-[200px]" data-type="storage" data-value="hdd-1tb">HDD 1TB</div>
                            <div class="spec-option w-[200px]" data-type="storage" data-value="ssd-256gb">SSD 256GB</div>
                            <div class="spec-option w-[200px]" data-type="storage" data-value="ssd-1tb">SSD 1TB</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="flex justify-between px-12 pb-6">
            <!-- Back Arrow -->
            <div class="arrow-next" onclick="prevStep(2)">
                <svg width="60" height="60" viewBox="0 0 40 40" class="text-[#7a7a7a]">
                    <path d="M25 12l-8 8 8 8" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" transform="rotate(-45 20 20)"/>
                </svg>
            </div>
            
            <!-- Next Arrow -->
            <div class="arrow-next" onclick="nextStep(3)" id="arrow3">
                <svg width="60" height="60" viewBox="0 0 40 40" class="text-[#7a7a7a]">
                    <path d="M15 12l8 8-8 8" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" transform="rotate(45 20 20)"/>
                </svg>
            </div>
        </footer>
    </div>

    <!-- Step 4: GPU & Screen -->
    <div id="step4" class="step">
        <div class="question-container">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:flex-grow gap-10 sm:gap-20 mb-12">
                <div class="text-xl font-normal text-[#7a7a7a]">1</div>
                <div class="text-xl font-normal text-[#7a7a7a] text-right">Kebutuhan &amp; Preferensi</div>
            </div>
            
            <div class="specs-container">
                <!-- Title Section -->
                <div class="specs-title">
                    <div class="leading-none">
                        <div class="text-xl mb-2 text-[#5a5858]">Spesifikasi</div>
                        <div class="text-[48px] font-light leading-[1] text-[#5a5858]">
                            GPU &<br />
                            LAYAR
                        </div>
                    </div>
                </div>
                
                <!-- Options Section -->
                <div class="specs-options">
                    <!-- GPU Section -->
                    <div>
                        <div class="text-2xl underline mb-8 font-light text-[#5a5858]">GPU</div>
                        <div class="space-y-4" id="gpuOptions">
                            <div class="spec-option w-[240px]" data-type="gpu" data-value="no-gpu">Tidak ada GPU</div>
                            <div class="spec-option w-[240px]" data-type="gpu" data-value="integrated">GPU Terintegrasi</div>
                            <div class="spec-option w-[240px]" data-type="gpu" data-value="entry-level">GPU Entry Level</div>
                            <div class="spec-option w-[240px]" data-type="gpu" data-value="mid-range">GPU Mid Range</div>
                            <div class="spec-option w-[240px]" data-type="gpu" data-value="high-end">GPU High End</div>
                        </div>
                    </div>
                    
                    <!-- Screen Section -->
                    <div>
                        <div class="text-2xl underline mb-8 font-light text-[#5a5858]">Layar</div>
                        <div class="space-y-4" id="screenOptions">
                            <div class="spec-option w-[200px]" data-type="screen" data-value="13-14-inch">13-14 inch</div>
                            <div class="spec-option w-[200px]" data-type="screen" data-value="15-16-inch">15-16 inch</div>
                            <div class="spec-option w-[200px]" data-type="screen" data-value="17-inch">17 inch</div>
                            <div class="spec-option w-[200px]" data-type="screen" data-value="high-res">High Resolution</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="flex justify-between px-12 pb-6">
            <!-- Back Arrow -->
            <div class="arrow-next" onclick="prevStep(3)">
                <svg width="60" height="60" viewBox="0 0 40 40" class="text-[#7a7a7a]">
                    <path d="M25 12l-8 8 8 8" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" transform="rotate(-45 20 20)"/>
                </svg>
            </div>
            
            <!-- Next Arrow -->
            <div class="arrow-next" onclick="submitForm()" id="arrow4">
                <svg width="60" height="60" viewBox="0 0 40 40" class="text-[#7a7a7a]">
                    <path d="M15 12l8 8-8 8" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" transform="rotate(45 20 20)"/>
                </svg>
            </div>
        </footer>
    </div>
</div>
@endsection

@section('scripts')
<script>
let selectedRAM = '';
let selectedStorage = '';
let selectedGPU = '';
let selectedScreen = '';

document.addEventListener('DOMContentLoaded', function() {
    // Initialize spec option clicks
    document.querySelectorAll('.spec-option').forEach(option => {
        option.addEventListener('click', function() {
            const type = this.dataset.type;
            const value = this.dataset.value;
            
            // Remove selection from same type
            document.querySelectorAll(`.spec-option[data-type="${type}"]`).forEach(opt => {
                opt.classList.remove('selected');
            });
            
            // Add selection to clicked option
            this.classList.add('selected');
            
            // Store selection
            if (type === 'ram') {
                selectedRAM = value;
            } else if (type === 'storage') {
                selectedStorage = value;
            } else if (type === 'gpu') {
                selectedGPU = value;
            } else if (type === 'screen') {
                selectedScreen = value;
            }
            
            updateArrowState();
        });
    });

    // Activity checkbox limit
    const activityCheckboxes = document.querySelectorAll('.activity-checkbox');
    const activityWarning = document.getElementById('activityWarning');
    const maxActivities = 3;

    activityCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedBoxes = document.querySelectorAll('.activity-checkbox:checked');
            
            if (checkedBoxes.length > maxActivities) {
                this.checked = false;
                activityWarning.style.display = 'block';
                setTimeout(() => {
                    activityWarning.style.display = 'none';
                }, 3000);
            } else {
                activityWarning.style.display = 'none';
            }
        });
    });

    // Validate bio form
    function validateBioForm() {
        const name = document.getElementById('name').value.trim();
        const program = document.getElementById('program').value;
        console.log('Validating bio form:', { name, program }); // Debug log
        return name !== '' && program !== '';
    }

    // Validate questions form
    function validateQuestionsForm() {
        const activities = document.querySelectorAll('input[name="activity"]:checked');
        const budget = document.querySelector('input[name="budget"]:checked');
        return activities.length > 0 && activities.length <= maxActivities && budget !== null;
    }

    // Validate specs form
    function validateSpecsForm() {
        return selectedRAM !== '' && selectedStorage !== '';
    }

    // Validate GPU & Screen form
    function validateGPUScreenForm() {
        return selectedGPU !== '' && selectedScreen !== '';
    }

    // Update arrow state
    function updateArrowState() {
        const currentStep = document.querySelector('.step.active').id;
        console.log('Current step:', currentStep); // Debug log
        
        if (currentStep === 'step1') {
            const arrow = document.getElementById('arrow1');
            const isValid = validateBioForm();
            console.log('Bio form valid:', isValid); // Debug log
            if (isValid) {
                arrow.classList.remove('arrow-disabled');
            } else {
                arrow.classList.add('arrow-disabled');
            }
        } else if (currentStep === 'step2') {
            const arrow = document.getElementById('arrow2');
            if (validateQuestionsForm()) {
                arrow.classList.remove('arrow-disabled');
            } else {
                arrow.classList.add('arrow-disabled');
            }
        } else if (currentStep === 'step3') {
            const arrow = document.getElementById('arrow3');
            if (validateSpecsForm()) {
                arrow.classList.remove('arrow-disabled');
            } else {
                arrow.classList.add('arrow-disabled');
            }
        } else if (currentStep === 'step4') {
            const arrow = document.getElementById('arrow4');
            if (validateGPUScreenForm()) {
                arrow.classList.remove('arrow-disabled');
            } else {
                arrow.classList.add('arrow-disabled');
            }
        }
    }

    // Make functions globally accessible
    window.validateBioForm = validateBioForm;
    window.validateQuestionsForm = validateQuestionsForm;
    window.validateSpecsForm = validateSpecsForm;
    window.validateGPUScreenForm = validateGPUScreenForm;
    window.updateArrowState = updateArrowState;

    // Add event listeners for form validation
    const nameInput = document.getElementById('name');
    const programSelect = document.getElementById('program');
    
    if (nameInput) {
        nameInput.addEventListener('input', function() {
            console.log('Name input changed:', this.value); // Debug log
            updateArrowState();
        });
    }
    
    if (programSelect) {
        programSelect.addEventListener('change', function() {
            console.log('Program changed:', this.value); // Debug log
            updateArrowState();
        });
    }
    
    document.querySelectorAll('input[name="activity"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateArrowState);
    });
    
    document.querySelectorAll('input[name="budget"]').forEach(radio => {
        radio.addEventListener('change', updateArrowState);
    });

    // Initial validation
    updateArrowState();
});

function nextStep(currentStep) {
    console.log('Next step clicked:', currentStep); // Debug log
    
    if (currentStep === 1) {
        const isValid = validateBioForm();
        console.log('Bio form valid in nextStep:', isValid); // Debug log
        
        if (!isValid) {
            alert('Mohon lengkapi semua data bio terlebih dahulu');
            return;
        }
        
        document.getElementById('step1').classList.remove('active');
        document.getElementById('step2').classList.add('active');
    } else if (currentStep === 2) {
        if (!validateQuestionsForm()) {
            alert('Mohon pilih minimal satu kegiatan dan budget');
            return;
        }
        
        document.getElementById('step2').classList.remove('active');
        document.getElementById('step3').classList.add('active');
    } else if (currentStep === 3) {
        if (!validateSpecsForm()) {
            alert('Mohon pilih spesifikasi RAM dan Penyimpanan');
            return;
        }
        
        document.getElementById('step3').classList.remove('active');
        document.getElementById('step4').classList.add('active');
    } else if (currentStep === 4) {
        if (!validateGPUScreenForm()) {
            alert('Mohon pilih spesifikasi GPU dan Layar');
            return;
        }
        
        submitForm();
    }
    
    updateArrowState();
}

function prevStep(targetStep) {
    if (targetStep === 1) {
        document.getElementById('step2').classList.remove('active');
        document.getElementById('step1').classList.add('active');
    } else if (targetStep === 2) {
        document.getElementById('step3').classList.remove('active');
        document.getElementById('step2').classList.add('active');
    } else if (targetStep === 3) {
        document.getElementById('step4').classList.remove('active');
        document.getElementById('step3').classList.add('active');
    }  else if (targetStep === 4) {
        document.getElementById('step5').classList.remove('active');
        document.getElementById('step4').classList.add('active');
    }
    
    updateArrowState();
}

function submitForm() {
    if (selectedGPU === '' || selectedScreen === '') {
        alert('Mohon pilih spesifikasi GPU dan Layar');
        return;
    }
    
    // Collect all form data
    const activities = document.querySelectorAll('input[name="activity"]:checked');
    const budget = document.querySelector('input[name="budget"]:checked');
    
    const formData = {
        name: document.getElementById('name').value,
        program: document.getElementById('program').value,
        activities: Array.from(activities).map(cb => cb.value),
        budget: budget.value,
        ram: selectedRAM,
        storage: selectedStorage,
        gpu: selectedGPU,
        screen: selectedScreen
    };
    
    console.log('Form Data:', formData);
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    if (!csrfToken) {
        console.error('CSRF token not found');
        alert('CSRF token tidak ditemukan. Mohon refresh halaman.');
        return;
    }
    
    // Submit data to Laravel backend
    fetch('/questions/submit', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(formData)
    })
    .then(async response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        // Check if response is ok
        if (!response.ok) {
            const errorText = await response.text();
            console.error('Error response:', errorText);
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        // Check content type
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const responseText = await response.text();
            console.error('Non-JSON response:', responseText);
            throw new Error('Server tidak mengembalikan JSON response');
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Success response:', data);
        
        if (data.success) {
            alert('Data berhasil disimpan!');
            window.location.href = data.redirect_url || '/results';
        } else {
            alert('Error: ' + (data.message || 'Terjadi kesalahan'));
            if (data.errors) {
                console.error('Validation errors:', data.errors);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim data: ' + error.message);
    });
}
</script>
@endsection