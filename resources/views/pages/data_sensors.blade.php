@extends('layouts.app')

@section('content')
    <style>
        .text-gray-500 {
            --tw-text-opacity: 1;
            color: #1037f0;

            .bg-white {
                --tw-bg-opacity: 1;
                background-color: #f0f1f8;
            }
        }

        /* Tùy chỉnh CSS */
        .date-group {
            display: flex;
            align-items: center;
            margin-right: 2rem;
            /* Khoảng cách giữa các nhóm */
        }

        .date-group label {
            margin-right: 0.5rem;
            /* Khoảng cách giữa nhãn và trường nhập liệu */
        }

        /* Nếu sử dụng Tailwind CSS */
        .space-x-2> :not([hidden])~ :not([hidden]) {
            margin-left: 0.5rem;
            /* Khoảng cách giữa nhãn và trường nhập liệu */
        }
    </style>
    <div class="panel">
        <div class="mb-5 flex items-center justify-between">
            <h5 class="text-lg font-semibold dark:text-white-light">Data Sensors</h5>
        </div>
        <div class="sm:ltr:mr-auto sm:rtl:ml-auto" x-data="{ search: false }" @click.outside="search = false">
            <form class="absolute inset-x-0 top-1/2 z-10 mx-4 hidden -translate-y-1/2 sm:relative sm:top-0 sm:mx-0 sm:block sm:translate-y-0" :class="{'!block' : search}" @submit.prevent="search = false" style="width: 600px">
                <div class="relative">
                    <input type="text" class="peer form-input bg-gray-100 placeholder:tracking-widest ltr:pl-9 ltr:pr-9 rtl:pl-9 rtl:pr-9 sm:bg-transparent ltr:sm:pr-4 rtl:sm:pl-4" placeholder="Search...">
                    <button type="button" class="absolute inset-0 h-9 w-9 appearance-none peer-focus:text-primary ltr:right-auto rtl:left-auto">
                        <svg class="mx-auto" width="16" height="16" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor" stroke-width="1.5" opacity="0.5"></circle>
                            <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                        </svg>
                    </button>
                    <button type="button" class="absolute top-1/2 block -translate-y-1/2 hover:opacity-80 ltr:right-2 rtl:left-2 sm:hidden" @click="search = false">
                        <svg width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"></circle>
                            <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                        </svg>
                    </button>
                </div>
            </form>
            <button type="button" class="search_btn rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 dark:bg-dark/40 dark:hover:bg-dark/60 sm:hidden" @click="search = ! search">
                <svg class="mx-auto h-4.5 w-4.5 dark:text-[#d0d2d6]" width="20" height="20" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor" stroke-width="1.5" opacity="0.5"></circle>
                    <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                </svg>
            </button>
        </div>
        <!-- Date Filter Form -->
        <form action="" method="GET" class="mb-4 flex justify-content-around space-x-12">
            @csrf
            <!-- Start Date Group -->
            <div class="flex items-center space-x-2" style="margin-right: 30px">
                <label for="start-date" class="text-sm font-medium text-gray-700 dark:text-gray-300">Start Date:</label>
                <input type="date" id="start-date" name="start_date" value="{{ request('start_date') }}"
                    class="p-2 border rounded dark:bg-dark dark:text-white">
            </div>

            <!-- End Date Group -->
            <div class="flex items-center space-x-2" style="margin-right: 30px">
                <label for="end-date" class="text-sm font-medium text-gray-700 dark:text-gray-300">End Date:</label>
                <input type="date" id="end-date" name="end_date" value="{{ request('end_date') }}"
                    class="p-2 border rounded dark:bg-dark dark:text-white">
            </div>

            <!-- Submit Button -->
            <div class="flex items-center">
                <button type="submit" class="text-white p-2 rounded" style="background: #4361ee">Apply Filter</button>
            </div>
        </form>

        <div class="mb-5">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>
                                Temperature
                                <a href="javascript:;" onclick="sortTable('temperature', 'asc')">↑</a>
                                <a href="javascript:;" onclick="sortTable('temperature', 'desc')">↓</a>
                            </th>
                            <th>
                                Humidity
                                <a href="javascript:;" onclick="sortTable('humidity', 'asc')">↑</a>
                                <a href="javascript:;" onclick="sortTable('humidity', 'desc')">↓</a>
                            </th>
                            <th>
                                Light
                                <a href="javascript:;" onclick="sortTable('light', 'asc')">↑</a>
                                <a href="javascript:;" onclick="sortTable('light', 'desc')">↓</a>
                            </th>
                            <th>
                                Time
                                <a href="javascript:;" onclick="sortTable('time', 'asc')">↑</a>
                                <a href="javascript:;" onclick="sortTable('time', 'desc')">↓</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allData as $index => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->temperature }}</td>
                                <td>{{ $item->humidity }}</td>
                                <td>{{ $item->light }}</td>
                                <td>{{ $item->time }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination and Items per Page -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <!-- Dropdown to select number of items per page -->
                    <form method="GET" action="{{ route('getAllData') }}" class="">
                        <span for="itemsPerPage" class="mr-2">Limit</span>
                        <select name="itemsPerPage" id="itemsPerPage" class="form-control w-auto border"
                            onchange="this.form.submit()">
                            <option value="10" {{ request('itemsPerPage') == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ request('itemsPerPage') == 15 ? 'selected' : '' }}>15</option>
                            <option value="20" {{ request('itemsPerPage') == 20 ? 'selected' : '' }}>20</option>
                        </select>
                    </form>

                    <!-- Pagination links -->
                    <div>
                        {!! $allData->links() !!}
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script>
        function sortTable(column, order) {
            // Implement sorting logic here
            console.log(`Sorting ${column} in ${order} order.`);
        }

        document.getElementById('searchInput').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(row => {
                let cells = row.getElementsByTagName('td');
                let match = false;

                for (let i = 0; i < cells.length; i++) {
                    if (cells[i].textContent.toLowerCase().includes(filter)) {
                        match = true;
                        break;
                    }
                }

                row.style.display = match ? '' : 'none';
            });
        });
    </script>
@endsection
