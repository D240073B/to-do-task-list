@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="mb-4">
            <a href="{{ route('tasks.index') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to Tasks
            </a>
        </div>

        <div class="glass-card">
            <div class="card-header-custom d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="mb-1">{{ $task->title }}</h2>
                    <small class="text-muted">Created {{ $task->created_at->format('F d, Y \a\t h:i A') }}</small>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-action btn-edit" id="btn-edit-task">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this task?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-action btn-delete" id="btn-delete-task">
                            <i class="bi bi-trash3"></i> Delete
                        </button>
                    </form>
                </div>
            </div>

            <div class="row g-4 mt-2">
                <div class="col-md-4">
                    <div class="detail-item">
                        <div class="detail-label"><i class="bi bi-flag me-1"></i> Status</div>
                        <div class="detail-value">
                            @if($task->status === 'pending')
                                <span class="badge badge-status badge-pending"><i class="bi bi-clock me-1"></i>Pending</span>
                            @elseif($task->status === 'in_progress')
                                <span class="badge badge-status badge-in-progress"><i class="bi bi-arrow-repeat me-1"></i>In Progress</span>
                            @else
                                <span class="badge badge-status badge-completed"><i class="bi bi-check-circle me-1"></i>Completed</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-item">
                        <div class="detail-label"><i class="bi bi-exclamation-circle me-1"></i> Priority</div>
                        <div class="detail-value">
                            @if($task->priority === 'high')
                                <span class="badge badge-priority badge-high"><i class="bi bi-exclamation-triangle me-1"></i>High</span>
                            @elseif($task->priority === 'medium')
                                <span class="badge badge-priority badge-medium"><i class="bi bi-dash-circle me-1"></i>Medium</span>
                            @else
                                <span class="badge badge-priority badge-low"><i class="bi bi-arrow-down-circle me-1"></i>Low</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-item">
                        <div class="detail-label"><i class="bi bi-calendar-event me-1"></i> Due Date</div>
                        <div class="detail-value">
                            @if($task->due_date)
                                <span class="{{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-danger fw-bold' : '' }}">
                                    {{ $task->due_date->format('F d, Y') }}
                                </span>
                                @if($task->due_date->isPast() && $task->status !== 'completed')
                                    <small class="text-danger d-block mt-1"><i class="bi bi-exclamation-triangle"></i> Overdue</small>
                                @endif
                            @else
                                <span class="text-muted">No due date set</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($task->description)
            <div class="mt-4">
                <div class="detail-label mb-2"><i class="bi bi-text-paragraph me-1"></i> Description</div>
                <div class="description-box">
                    {{ $task->description }}
                </div>
            </div>
            @endif

            <div class="mt-4 pt-3 border-top border-secondary">
                <small class="text-muted">
                    <i class="bi bi-clock-history me-1"></i> Last updated {{ $task->updated_at->diffForHumans() }}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
