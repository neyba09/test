@component('mail::message')
    # Новая задача создана

    **Название:** {{ $task->title }}

    **Описание:** {{ $task->description }}

    **Статус:** {{ $task->status }}

    **Срок:** {{ $task->due_date }}

@endcomponent
