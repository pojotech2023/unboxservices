@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Dashboard</h3>
                </div>
            </div>
            <div class="container">
                <div class="page-inner">
                    <!-- Sites Overview -->
                    <h3 class="fw-bold mb-1">Sites Overview</h3>
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-primary card-round">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="icon-big text-center">
                                                <i class="bi bi-building"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-stats">
                                            <div class="numbers">
                                                <p class="card-category">Total Sites</p>
                                                <h4 class="card-title">{{ $totalSites }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-info card-round">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="icon-big text-center">
                                                <i class="bi bi-building-add"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-stats">
                                            <div class="numbers">
                                                <p class="card-category">New Sites</p>
                                                <h4 class="card-title">{{ $newSites }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-warning card-round">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="icon-big text-center">
                                                <i class="bi bi-buildings"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-stats">
                                            <div class="numbers">
                                                <p class="card-category">Ongoing Sites</p>
                                                <h4 class="card-title">{{ $ongoingSites }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="card card-stats card-success card-round">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="icon-big text-center">
                                                <i class="bi bi-building-check"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-stats">
                                            <div class="numbers">
                                                <p class="card-category">Completed Sites</p>
                                                <h4 class="card-title">{{ $completedSites }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Dropdown status -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Filter by Status:</label>
                    <select id="statusFilter" class="form-select w-auto d-inline-block">
                        <option value="All">All</option>
                        <option value="New" selected>New</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>

                <!-- Doughnut Charts -->
                <div class="row" id="chartsContainer">
                    @foreach ($charts as $index => $chart)
                        <div class="col-md-4 chart-card" data-status="{{ $chart['status'] }}">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">{{ $chart['site_name'] }}</div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="doughnutChart{{ $index }}" width="200"
                                            height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const backgroundColors = ["#f3545dcc", "#58ef5d", "#1d7af3b8"];
            const chartLabels = ["Pending Amount", "Settled Amount", "Total Value"];
            const chartData = @json($charts);
            const chartInstances = [];

            chartData.forEach((item, index) => {
                const ctx = document.getElementById(`doughnutChart${index}`).getContext("2d");
                const chart = new Chart(ctx, {
                    type: "doughnut",
                    data: {
                        datasets: [{
                            data: item.data,
                            backgroundColor: backgroundColors,
                        }],
                        labels: chartLabels,
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: "bottom",
                            }
                        },
                        layout: {
                            padding: 20
                        }
                    }
                });
                chartInstances.push(chart);
            });

            // Filter function
            document.getElementById("statusFilter").addEventListener("change", function() {
                const selectedStatus = this.value;
                const allCharts = document.querySelectorAll(".chart-card");

                allCharts.forEach(card => {
                    const cardStatus = card.getAttribute("data-status");
                    if (selectedStatus === "All" || cardStatus === selectedStatus) {
                        card.style.display = "block";
                    } else {
                        card.style.display = "none";
                    }
                });
            });

            // Auto trigger filter for default "New" on page load
            window.addEventListener("DOMContentLoaded", function() {
                document.getElementById("statusFilter").dispatchEvent(new Event("change"));
            });
        </script>
    @endsection
