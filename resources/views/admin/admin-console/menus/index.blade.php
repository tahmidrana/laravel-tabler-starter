@extends('layouts.app')

@section('breadcrumbs')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Admin Console
                </div>
                <h2 class="page-title">
                    Menus
                </h2>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <a href="#" data-bs-toggle="modal" data-bs-target="#addMenuModal" class="btn btn-primary mb-2">Add Menu</a>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Menus</h3>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Icon</th>
                                <th>Parent</th>
                                <th>Order</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menus as $menu)
                            <tr>
                                <td style="{{ $menu->parent_menu_id ? '' : 'border-left: 3px solid blue' }}">
                                    <span style="{{ $menu->parent_menu_id ? '' : 'font-weight: bold;' }}">{{ $menu->title }}</span>
                                </td>
                                <td>{!! $menu->menu_icon ? '<i class="ti ti-'.$menu->menu_icon.' fs-3"></i>' : '-' !!}</td>
                                <td>{{ $menu->parentMenu->title ?? '-' }}</td>
                                <td>{{ $menu->menu_order }}</td>
                                <td>
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#modal_update_menu_{{ $menu->id }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('admin-console.menus.destroy', $menu->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Add Menu Modal -->
                            <div class="modal modal-blur fade" id="modal_update_menu_{{ $menu->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="updateMenuModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addMenuModalLabel">Update Menu</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin-console.menus.update', ['menu'=> $menu->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group mb-3">
                                                    <label for="title_{{ $menu->id }}" class="form-label">Title *</label>
                                                    <input type="text" class="form-control" id="title_{{ $menu->id }}" name="title" required
                                                        value="{{ $menu->title }}" />
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="route_name_{{ $menu->id }}" class="form-label">Route Name </label>
                                                    <input type="text" class="form-control" id="route_name_{{ $menu->id }}" name="route_name"
                                                        value="{{ $menu->route_name }}" />
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="menu_icon_{{ $menu->id }}" class="form-label">Menu Icon <small>(<a href="https://tabler.io/icons" target="_blank">Icons</a>)</small></label>
                                                    <input type="text" class="form-control" id="menu_icon_{{ $menu->id }}" name="menu_icon" value="{{ $menu->menu_icon }}" placeholder="Ex: users (for ti ti-users)" />
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="parent_menu_id_{{ $menu->id }}" class="form-label">Parent</label>
                                                    <select class="form-control" id="parent_menu_id_{{ $menu->id }}" name="parent_menu_id">
                                                        <option value="">None</option>
                                                        @foreach ($menus as $sub_menu)
                                                            <option value="{{ $sub_menu->id }}" {{ $menu->parent_menu_id == $sub_menu->id ? 'selected' : '' }}>
                                                                {{ $sub_menu->parent_menu_id ? '---' : '' }}{{ $sub_menu->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group mb-3">
                                                            <label for="menu_order_{{ $menu->id }}" class="form-label">Order </label>
                                                            <input type="number" class="form-control" id="menu_order_{{ $menu->id }}" name="menu_order"
                                                                value="{{ $menu->menu_order }}" />
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group mb-3">
                                                            <label for="is_active_{{ $menu->id }}" class="form-label">Is active</label>
                                                            <select class="form-control" id="is_active_{{ $menu->id }}" name="is_active" required>
                                                                <option value="1" {{ $menu->is_active == 1 ? 'selected' : '' }}>Yes</option>
                                                                <option value="0" {{ $menu->is_active == 1 ? 'selected' : '' }}>No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Menu Modal -->
        <div class="modal modal-blur fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMenuModalLabel">Add New Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin-console.menus.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="title" class="form-label">Title *</label>
                                <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') }}" />
                            </div>

                            <div class="form-group mb-3">
                                <label for="route_name" class="form-label">Route Name </label>
                                <input type="text" class="form-control" id="route_name" name="route_name" value="{{ old('route_name') }}" />
                            </div>

                            <div class="form-group mb-3">
                                <label for="menu_icon" class="form-label">Menu Icon <small>(<a href="https://tabler.io/icons" target="_blank">Icons</a>)</small></label>
                                <input type="text" class="form-control" id="menu_icon" name="menu_icon" value="{{ old('menu_icon') }}" placeholder="Ex: users (for ti ti-users)" />
                            </div>

                            <div class="form-group mb-3">
                                <label for="parent_menu_id" class="form-label">Parent</label>
                                <select class="form-control" id="parent_menu_id" name="parent_menu_id">
                                    <option value="">None</option>
                                    @foreach ($menus as $sub_menu)
                                        <option value="{{ $sub_menu->id }}">{{ $sub_menu->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="menu_order" class="form-label">Order </label>
                                        <input type="number" class="form-control" id="menu_order" name="menu_order" value="{{ old('menu_order', 1) }}" />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label for="is_active" class="form-label">Is active</label>
                                        <select class="form-control" id="is_active" name="is_active" required>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Trigger Modal -->
<script>
    $(document).ready(function() {
        //
    });
</script>

@endsection
