<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];
?>

<div
    x-data="{
        show: <?php echo \Illuminate\Support\Js::from($show)->toHtml() ?>,
        focusables() {
            // All focusable element types...
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...$el.querySelectorAll(selector)]
                // All non-disabled elements...
                .filter(el => ! el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) -1 },
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
            <?php echo e($attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : ''); ?>

        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
    x-on:open-modal.window="$event.detail == '<?php echo e($name); ?>' ? show = true : null"
    x-on:close-modal.window="$event.detail == '<?php echo e($name); ?>' ? show = false : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-show="show"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
    style="display: <?php echo e($show ? 'block' : 'none'); ?>;"

>
    <div
        x-show="show"
        class=" fixed inset-0 transform transition-all"
        x-on:click="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"

    >
        <div class=" absolute inset-0 bg-amber-200 dark:bg-gray-900 opacity-75"
        ></div>
    </div>

   <div
       style="display: flex;align-items: center;justify-content: center;height: 100vh;width:100%;
       ">
       <div
           x-show="show"x-on:click.outside="show=true"
           class="mb-6 bg-white  dark:bg-gray-800 rounded-lg overflow-hidden shadow-[0px_0px_20px_5px_rgba(0,0,0,0.5)] transform transition-all sm:w-full <?php echo e($maxWidth); ?> sm:mx-auto justify-items-center "
           x-transition:enter="ease-out duration-300"
           x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
           x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
           x-transition:leave="ease-in duration-200"
           x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
           x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"

       >
           <header class="text-center border-b font-bold bg-amber-400 py-2 w-full">
               <?php echo e(__('افزودن کار جدید')); ?>

           </header>

           <main class="px-6 py-4">
               <?php echo e($slot); ?>

           </main>
           <footer class="flex text-center w-full">
               <div class="w-3/4 bg-green-300 justify-items-center">
                   <button type="submit" wire:click="store()" class="py-2">
                       
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 hover:fill-emerald-950">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                       </svg>
                   </button>
               </div>
               <div class="w-1/4 bg-gray-300 justify-items-center">
                   <button type="submit" wire:click="cancel_store()" class="py-2">
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                           <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                       </svg>

                       
                   </button>

               </div>

           </footer>


       </div>
   </div>
</div>
<?php /**PATH D:\xampp\htdocs\todo_list\resources\views/components/modal/create.blade.php ENDPATH**/ ?>