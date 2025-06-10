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
        font-size: 0.75rem;
        color: #6b6b6b;
        padding: 0.125rem 0;
        width: 12rem;
    }

    input[type="text"]::placeholder {
        color: transparent;
    }

    /* Custom select styling */
    select {
        font-family: "Roboto Mono", monospace;
        font-size: 0.625rem;
        color: #6b6b6b;
        background: transparent;
        border: none;
        padding: 0;
        margin: 0;
        outline: none;
        box-shadow: none;
        cursor: pointer;
    }

    select option {
        background: #f3f1f0;
        color: #3a3a3a;
        font-family: "Roboto Mono", monospace;
        font-size: 0.625rem;
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
        transition: transform 0.2s ease;
    }

    .arrow-next:hover {
        transform: scale(1.1);
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
</style>
@endsection

@section('content')
<div class="min-h-screen flex flex-col">
    <!-- Step 1: Bio Data -->
    <div id="step1" class="step active">
        <main class="flex flex-1 px-6 py-8">
            <div class="flex flex-col justify-center flex-1 max-w-xs">
                <h1 class="text-[5rem] font-normal leading-[4.5rem] text-[#6b6b6b] select-none">
                    BIO<br/>DATA
                </h1>
            </div>
            
            <form class="flex flex-col justify-center flex-1 max-w-md space-y-6 text-[#6b6b6b] text-[0.75rem] font-normal leading-tight ml-20" id="bioForm">
                <div class="flex items-center space-x-4">
                    <label class="w-20 select-none" for="name">
                        Nama
                    </label>
                    <input autocomplete="off" id="name" name="name" type="text" required/>
                </div>
                
                <div class="flex items-start space-x-4">
                    <label class="w-20 select-none pt-1" for="program">
                        Program Studi
                    </label>
                    <div class="flex flex-col space-y-1">
                        <select class="w-48 cursor-pointer" id="program" name="program" size="3" required>
                            <option value="Teknik Informatika">Teknik Informatika</option>
                            <option value="Teknik Multimedia Digital">Teknik Multimedia Digital</option>
                            <option value="Teknik Multimedia Jaringan">Teknik Multimedia Jaringan</option>
                        </select>
                    </div>
                </div>
            </form>
        </main>
        
        <footer class="flex justify-end px-6 py-4">
            <div class="arrow-next" onclick="nextStep(1)" id="arrow1">
                <svg width="40" height="40" viewBox="0 0 40 40" class="text-[#6b6b6b]">
                    <path d="M15 12l8 8-8 8" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" transform="rotate(45 20 20)"/>
                </svg>
            </div>
        </footer>
    </div>

    <!-- Step 2: Questions -->
    <div id="step2" class="step">

        <div class="flex flex-col sm:flex-row sm:justify-between sm:flex-grow gap-10 sm:gap-20">
            <div class="text-[12px] font-normal text-[#7a7a7a]">1</div>
            <div class="text-[12px] font-normal text-[#7a7a7a] text-right mb-2">Kebutuhan &amp; Preferensi</div>
        </div>

        <main class="flex-grow px-6 pt-6 max-w-7xl mx-auto flex flex-col sm:flex-row sm:justify-between sm:items-start gap-10 sm:gap-0">
            
            <div class="flex flex-col sm:flex-row sm:justify-between sm:flex-grow gap-10 sm:gap-20">
                <!-- Activities Section -->
                <section class="max-w-[320px]">
                    <h2 class="text-[20px] leading-[1.1] font-normal mb-4 text-[#4a4a4a]">
                        Apa kegiatan utama yang<br />
                        kamu lakukan yang<br />
                        menggunakan laptop?
                    </h2>
                    
                    <form class="flex flex-col gap-1" id="activitiesForm">
                        <label class="option-label inline-flex items-center gap-2 text-[10px] font-normal bg-[#d9d9d9] text-[#4a4a4a] px-2 py-[2px] w-max">
                            <input type="checkbox" name="activity" value="programming" class="w-3 h-3" />
                            Programming/Coding
                        </label>
                        <label class="option-label inline-flex items-center gap-2 text-[10px] font-normal bg-[#d9d9d9] text-[#4a4a4a] px-2 py-[2px] w-max">
                            <input type="checkbox" name="activity" value="desain" class="w-3 h-3" />
                            Desain Grafis/Multimedia
                        </label>
                        <label class="option-label inline-flex items-center gap-2 text-[10px] font-normal bg-[#d9d9d9] text-[#4a4a4a] px-2 py-[2px] w-max">
                            <input type="checkbox" name="activity" value="machine-learning" class="w-3 h-3" />
                            Machine Learning/AI
                        </label>
                        <label class="option-label inline-flex items-center gap-2 text-[10px] font-normal bg-[#d9d9d9] text-[#4a4a4a] px-2 py-[2px] w-max">
                            <input type="checkbox" name="activity" value="game-dev" class="w-3 h-3" />
                            Pengembangan Game
                        </label>
                        <label class="option-label inline-flex items-center gap-2 text-[10px] font-normal bg-[#d9d9d9] text-[#4a4a4a] px-2 py-[2px] w-max">
                            <input type="checkbox" name="activity" value="office" class="w-3 h-3" />
                            Office/Produktivitas
                        </label>
                        <label class="option-label inline-flex items-center gap-2 text-[10px] font-normal bg-[#d9d9d9] text-[#4a4a4a] px-2 py-[2px] w-max">
                            <input type="checkbox" name="activity" value="network" class="w-3 h-3" />
                            Network Configurating
                        </label>
                        <label class="option-label inline-flex items-center gap-2 text-[10px] font-normal bg-[#d9d9d9] text-[#4a4a4a] px-2 py-[2px] w-max">
                            <input type="checkbox" name="activity" value="database" class="w-3 h-3" />
                            Database
                        </label>
                    </form>
                </section>

                <!-- Budget Section -->
                <section class="max-w-[320px]">
                    <h2 class="text-[20px] leading-[1.1] font-normal mb-4 text-[#4a4a4a]">
                        Berapa <em>budget</em> ideal untuk<br />
                        laptop mahasiswa TIK<br />
                        menurut kamu?
                    </h2>
                    
                    <form class="flex flex-col gap-1 text-[10px] font-normal text-[#4a4a4a]" id="budgetForm">
                        <label class="option-label inline-flex items-center gap-2 bg-[#d9d9d9] px-2 py-[2px] w-max">
                            <input type="radio" name="budget" value="less-5m" class="w-3 h-3" />
                            &lt; Rp5.000.000
                        </label>
                        <label class="option-label inline-flex items-center gap-2 bg-[#e6e6e6] px-2 py-[2px] w-max">
                            <input type="radio" name="budget" value="5m-8m" class="w-3 h-3" />
                            Rp5.000.000 - 8.000.000
                        </label>
                        <label class="option-label inline-flex items-center gap-2 bg-[#d9d9d9] px-2 py-[2px] w-max">
                            <input type="radio" name="budget" value="8m-12m" class="w-3 h-3" />
                            Rp8.000.000 - 12.000.000
                        </label>
                        <label class="option-label inline-flex items-center gap-2 bg-[#e6e6e6] px-2 py-[2px] w-max">
                            <input type="radio" name="budget" value="12m-15m" class="w-3 h-3" />
                            Rp12.000.000 - 15.000.000
                        </label>
                        <label class="option-label inline-flex items-center gap-2 bg-[#d9d9d9] px-2 py-[2px] w-max">
                            <input type="radio" name="budget" value="more-15m" class="w-3 h-3" />
                            &gt;Rp15.000.000
                        </label>
                    </form>
                </section>
            </div>
        </main>

       <footer class="flex justify-between items-center w-full max-w-full mx-auto mt-10 px-10">
    <!-- Back Arrow -->
            <div class="arrow-next" onclick="prevStep(1)">
                <svg width="40" height="40" viewBox="0 0 40 40" class="text-[#7a7a7a]">
                    <path d="M25 12l-8 8 8 8" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" transform="rotate(-45 20 20)"/>
                </svg>
            </div>

            <!-- Next Arrow -->
            <div class="arrow-next" onclick="nextStep(2)" id="arrow2">
                <svg width="40" height="40" viewBox="0 0 40 40" class="text-[#7a7a7a]">
                    <path d="M15 12l8 8-8 8" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" transform="rotate(45 20 20)"/>
                </svg>
            </div>
        </footer>

    </div>

    <!-- Step 3: RAM & Storage -->
    <div id="step3" class="step">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:flex-grow gap-10 sm:gap-20">
            <div class="text-[12px] font-normal text-[#7a7a7a]">1</div>
            <div class="text-[12px] font-normal text-[#7a7a7a] text-right mb-2">Kebutuhan &amp; Preferensi</div>
        </div>
        
        <div class="flex flex-1 justify-center items-center px-6">
            <div class="mr-20 leading-none">
                <div class="text-[12px] mb-1 text-[#5a5858]">Spesifikasi</div>
                <div class="text-[40px] font-light leading-[1] text-[#5a5858]">
                    RAM &<br />
                    PENYIM<br />
                    PANAN
                </div>
            </div>
            
            <div class="flex space-x-20">
                <!-- RAM Section -->
                <div>
                    <div class="text-[18px] underline mb-3 font-light text-[#5a5858]">RAM</div>
                    <div class="space-y-1 text-[10px] font-normal" id="ramOptions">
                        <div class="spec-option px-1 py-[2px] w-[60px]" data-type="ram" data-value="4gb">4 GB</div>
                        <div class="spec-option px-1 py-[2px] w-[60px]" data-type="ram" data-value="8gb">8 GB</div>
                        <div class="spec-option px-1 py-[2px] w-[60px]" data-type="ram" data-value="16gb">16 GB</div>
                        <div class="spec-option px-1 py-[2px] w-[90px]" data-type="ram" data-value="32gb">32 GB/Lebih</div>
                    </div>
                </div>
                
                <!-- Storage Section -->
                <div>
                    <div class="text-[18px] underline mb-3 font-light text-[#5a5858]">Penyimpanan</div>
                    <div class="space-y-1 text-[10px] font-normal" id="storageOptions">
                        <div class="spec-option px-1 py-[2px] w-[90px]" data-type="storage" data-value="hdd-500gb">HDD 500 GB</div>
                        <div class="spec-option px-1 py-[2px] w-[90px]" data-type="storage" data-value="hdd-1tb">HDD 1 TB</div>
                        <div class="spec-option px-1 py-[2px] w-[90px]" data-type="storage" data-value="ssd-256gb">SSD 256 GB</div>
                        <div class="spec-option px-1 py-[2px] w-[130px]" data-type="storage" data-value="ssd-1tb">SSD 1 TB (atau Lebih)</div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="flex justify-between px-6 pb-6">
            <!-- Back Arrow -->
            <div class="arrow-next" onclick="prevStep(2)">
                <svg width="40" height="40" viewBox="0 0 40 40" class="text-[#7a7a7a]">
                    <path d="M25 12l-8 8 8 8" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" transform="rotate(-45 20 20)"/>
                </svg>
            </div>
            
            <!-- Next Arrow -->
            <div class="arrow-next" onclick="nextStep(3)" id="arrow3">
                <svg width="40" height="40" viewBox="0 0 40 40" class="text-[#7a7a7a]">
                    <path d="M15 12l8 8-8 8" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" transform="rotate(45 20 20)"/>
                </svg>
            </div>
        </footer>
    </div>

    <!-- Step 4: GPU & Screen -->
    <div id="step4" class="step">
        <div class="flex justify-between px-6 pt-6 text-[12px] leading-none">
            <div>3</div>
            <div>Spesifikasi minimum yang kamu rekomendasikan</div>
        </div>
        
        <div class="min-h-screen flex items-center justify-center p-6" style="background-color: #f3f0ec;">
            <div class="max-w-7xl w-full flex flex-col sm:flex-row justify-between items-center sm:items-start text-[#555555]">
                <!-- Title Section -->
                <div class="w-full sm:w-1/4 flex flex-col items-start">
                    <p class="text-[12px] mb-1 select-none">Spesifikasi</p>
                    <h1 class="text-[40px] font-light leading-[1.1] select-none" style="font-family: 'Special Elite', cursive;">GPU &<br />LAYAR</h1>
                </div>
                
                <!-- GPU Section -->
                <div class="w-full sm:w-1/3 flex flex-col items-center sm:items-start mt-10 sm:mt-0">
                    <h2 class="text-[20px] mb-4 select-none" style="font-family: 'Special Elite', cursive;">GPU</h2>
                    <div class="space-y-1 w-full max-w-xs text-[10px]" id="gpuOptions">
                        <div class="spec-option border border-gray-400 rounded px-2 py-[2px] select-none" data-type="gpu" data-value="no-gpu">Tidak memerlukan GPU khusus</div>
                        <div class="spec-option border border-gray-400 rounded px-2 py-[2px] select-none" data-type="gpu" data-value="integrated">GPU integrasi terbaru</div>
                        <div class="spec-option border border-gray-400 rounded px-2 py-[2px] select-none" data-type="gpu" data-value="entry-level">GPU entry level (NVIDIA GTX 1650/AMD Setara)</div>
                        <div class="spec-option border border-gray-400 rounded px-2 py-[2px] select-none" data-type="gpu" data-value="mid-range">GPU mid-range (NVIDIA RTX 3050/AMD setara)</div>
                        <div class="spec-option border border-gray-400 rounded px-2 py-[2px] select-none" data-type="gpu" data-value="high-end">GPU high-end (NVIDIA RTX 3060/AMD setara)</div>
                    </div>
                </div>
                
                <!-- Screen Section -->
                <div class="w-full sm:w-1/3 flex flex-col items-center sm:items-start mt-10 sm:mt-0">
                    <h2 class="text-[20px] mb-4 select-none text-center sm:text-left" style="font-family: 'Special Elite', cursive;">Ukuran &<br />Resolusi Layar</h2>
                    <div class="space-y-1 w-full max-w-xs text-[10px]" id="screenOptions">
                        <div class="spec-option border border-gray-400 rounded px-2 py-[2px] select-none" data-type="screen" data-value="13-14-inch">13-14 inch <span class="italic font-normal">(compact)</span></div>
                        <div class="spec-option border border-gray-400 rounded px-2 py-[2px] select-none" data-type="screen" data-value="15-16-inch">15-16 inch <span class="italic font-normal">(standard)</span></div>
                        <div class="spec-option border border-gray-400 rounded px-2 py-[2px] select-none" data-type="screen" data-value="17-inch">17 inch <span class="italic font-normal">(desktop replacement)</span></div>
                        <div class="spec-option border border-gray-400 rounded px-2 py-[2px] select-none" data-type="screen" data-value="high-res">High Resolution (1440p/4K)</div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="flex justify-between px-6 pb-6">
            <!-- Back Arrow -->
            <div class="arrow-next" onclick="prevStep(3)">
                <svg width="40" height="40" viewBox="0 0 40 40" class="text-[#7a7a7a]">
                    <path d="M25 12l-8 8 8 8" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" transform="rotate(-45 20 20)"/>
                </svg>
            </div>
            
            <!-- Next Arrow -->
            <div class="arrow-next" onclick="submitForm()" id="arrow4">
                <svg width="40" height="40" viewBox="0 0 40 40" class="text-[#7a7a7a]">
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

    // Validate bio form
    function validateBioForm() {
        const name = document.getElementById('name').value.trim();
        const program = document.getElementById('program').value;
        
        return name !== '' && program !== '';
    }

    // Validate questions form
    function validateQuestionsForm() {
        const activities = document.querySelectorAll('input[name="activity"]:checked');
        const budget = document.querySelector('input[name="budget"]:checked');
        
        return activities.length > 0 && budget !== null;
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
        
        if (currentStep === 'step1') {
            const arrow = document.getElementById('arrow1');
            if (validateBioForm()) {
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
        } } 
    }

    // Make updateArrowState globally accessible
    window.updateArrowState = updateArrowState;

    // Add event listeners for form validation
    document.getElementById('name').addEventListener('input', updateArrowState);
    document.getElementById('program').addEventListener('change', updateArrowState);
    
    document.querySelectorAll('input[name="activity"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateArrowState);
    });
    
    document.querySelectorAll('input[name="budget"]').forEach(radio => {
        radio.addEventListener('change', updateArrowState);
    });

    // Initial validation
    updateArrowState();
);

function nextStep(currentStep) {
    if (currentStep === 1) {
        const name = document.getElementById('name').value.trim();
        const program = document.getElementById('program').value;
        
        if (name === '' || program === '') {
            alert('Mohon lengkapi semua data bio terlebih dahulu');
            return;
        }
        
        document.getElementById('step1').classList.remove('active');
        document.getElementById('step2').classList.add('active');
    } else if (currentStep === 2) {
        const activities = document.querySelectorAll('input[name="activity"]:checked');
        const budget = document.querySelector('input[name="budget"]:checked');
        
        if (activities.length === 0) {
            alert('Mohon pilih minimal satu kegiatan');
            return;
        }
        
        if (!budget) {
            alert('Mohon pilih budget');
            return;
        }
        
        document.getElementById('step2').classList.remove('active');
        document.getElementById('step3').classList.add('active');
    } else if (currentStep === 3) {
        if (selectedRAM === '' || selectedStorage === '') {
            alert('Mohon pilih spesifikasi RAM dan Penyimpanan');
            return;
        }
        
        document.getElementById('step3').classList.remove('active');
        document.getElementById('step4').classList.add('active');
    }   else if (currentStep === 4) {
        if (selectedGPU === '' || selectedScreen === '') {
            alert('Mohon pilih spesifikasi GPU dan Layar');
            return;
        }

        document.getElementById('step4').classList.remove('active');
        document.getElementById('step5').classList.add('active');
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