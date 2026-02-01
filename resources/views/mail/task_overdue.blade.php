@component('mail::message')
    # Задача просрочена

    Задача **{{ $task->title }}** не была выполнена в срок ({{ $task->due_date }}).

    @component('mail::button', ['url' => url('/tasks/'.$task->id)])
        Посмотреть задачу
    @endcomponent

    Спасибо,<br>
    {{ config('app.name') }}
@endcomponent
