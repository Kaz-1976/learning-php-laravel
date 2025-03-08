<div class="flex flex-row w-full py-4 border-t-2 border-b-2 border-sky-950 dark:border-sky-50">
    <div class="flex flex-row basis-1/5 justify-center">
        <span class="flex text-center font-bold text-2xl md:text-4xl text-sky-950 dark:text-sky-50">合計</span>
    </div>
    <div class="flex flex-row basis-2/5 items-end">
        <span
            class="w-4/5 text-right font-bold text-2xl md:text-4xl text-sky-950 dark:text-sky-50">{{ number_format($totalQty) }}</span>
        <span class="w-1/5 h-fit text-center text-xl md:text-2xl text-sky-900 dark:text-sky-100">点</span>
    </div>
    <div class="flex flex-row basis-2/5 items-end">
        <span
            class="w-4/5 text-right font-bold text-2xl md:text-4xl text-sky-950 dark:text-sky-50">{{ number_format($totalAmount) }}</span>
        <span class="w-1/5 h-fit text-center text-xl md:text-2xl text-sky-900 dark:text-sky-100">円</span>
    </div>
</div>
