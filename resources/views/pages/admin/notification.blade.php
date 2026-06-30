@extends('layouts.admin')

@section('title', 'Order Notifications')

@section('content')

<div x-data="notificationPage()">
    <div class="px-6 py-4">
        <h1 class="text-2xl font-semibold text-gray-700 mb-4">All Order Notifications</h1>

        @forelse ($waitingOrders as $order)
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 mb-4 hover:shadow-lg transition flex justify-between items-center">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">{{ $order->user->name }}</h2>
                <p class="text-sm text-gray-500">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                @if ($order->payment)
                    <p class="text-sm text-gray-500">Payment Method: {{ $order->payment->method_name }}</p>
                @else
                    <p class="text-sm text-red-500">Payment Method: Not selected</p>
                @endif
                <p class="text-xs text-gray-400">Date: {{ $order->created_at->format('d-m-Y H:i') }}</p>
            </div>

            <div>
                @php
                $orderJson = [
                    "order_code" => $order->order_code,
                    "status" => $order->status,
                    "total_price" => $order->total_price,
                    "created_at" => $order->created_at->format('Y-m-d H:i:s'),
                    "payment" => $order->payment,
                    "payment_proof" => $order->payment_proof,
                    "order_items" => $order->orderItems->map(function($item) {
                        return [
                            "quantity" => $item->quantity,
                            "product" => ["name" => $item->product->name],
                        ];
                    })->values(),
                ];
                @endphp

                <button 
                    @click='showDetail(@json($orderJson))'
                    class="text-blue-600 hover:underline text-sm font-medium">
                    View Details
                </button>
            </div>
        </div>
        @empty
        <div class="text-center text-gray-500">
            No order notifications available.
        </div>
        @endforelse
    </div>

    <!-- ✅ Detail Popup -->
    <template x-if="openPopup">
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white w-full max-w-lg max-h-[90vh] overflow-y-auto p-6 rounded-lg shadow-2xl border relative">
                <button class="absolute top-3 right-3 text-gray-500 hover:text-black" @click="closePopup()">
                    <i class="fas fa-times text-lg"></i>
                </button>

                <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b-2 border-blue-500 pb-3">
                    Order Details
                </h2>

                <template x-if="selectedOrder">
                    <div class="space-y-6">

                        <!-- Products List -->
                        <div>
                            <h3 class="text-lg font-semibold text-blue-700 mb-3 flex items-center">
                                <i class='bx bx-package mr-2 text-blue-500 text-xl'></i>
                                Product List
                            </h3>
                            <ul class="list-disc list-inside text-sm text-gray-700 pl-2 space-y-2">
                                <template x-for="item in groupedItems()" :key="item.product.name">
                                    <li class="ml-1">
                                        <span class="font-medium" x-text="item.product.name"></span>
                                        <span class="text-gray-500"> - Qty: </span>
                                        <span x-text="item.quantity"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>

                        <!-- Payment Info -->
                        <div>
                            <h3 class="text-lg font-semibold text-blue-700 mb-3 flex items-center">
                                <i class='bx bx-wallet mr-2 text-green-500 text-xl'></i>
                                Payment Information
                            </h3>
                            <div class="text-sm text-gray-700 space-y-1">
                                <p><span class="font-medium">Method:</span> <span x-text="selectedOrder.payment?.method_name || '-'"></span></p>
                                <p><span class="font-medium">Total:</span> Rp <span x-text="formatNumber(selectedOrder.total_price)"></span></p>
                                <p><span class="font-medium">Date:</span> <span x-text="formatDate(selectedOrder.created_at)"></span></p>
                                <p>
                                    <span class="font-medium">Status:</span>
                                    <span 
                                        x-text="selectedOrder.status === 'pending_payment' ? 'Unpaid' : 'Paid'"
                                        :class="selectedOrder.status === 'pending_payment' 
                                            ? 'text-red-600 font-semibold' 
                                            : 'text-green-600 font-semibold'"
                                    ></span>
                                </p>
                            </div>
                        </div>

                        <!-- Payment Proof -->
                        <template x-if="selectedOrder.status === 'waiting'">
                            <div>
                                <h3 class="text-lg font-semibold text-blue-700 mb-3 flex items-center">
                                    <i class='bx bx-image mr-2 text-purple-500 text-xl'></i>
                                    Payment Proof
                                </h3>
                                <div class="border rounded-md overflow-hidden">
                                    <img :src="'/storage/' + selectedOrder.payment_proof" 
                                        alt="Payment Proof" 
                                        class="w-full object-contain max-h-96">
                                </div>
                            </div>
                        </template>

                        <!-- Confirm / Reject Buttons -->
                        <div class="flex justify-end space-x-6 pt-4">
                            <form :action="'/order/reject/' + selectedOrder.order_code" method="POST">
                                @csrf
                                <button 
                                    type="submit"
                                    :disabled="selectedOrder.status === 'pending_payment'"
                                    :class="selectedOrder.status === 'pending_payment' 
                                        ? 'text-gray-400 cursor-not-allowed' 
                                        : 'text-red-600 hover:underline'"
                                >
                                    ✖ Reject
                                </button>
                            </form>

                            <form :action="'/order/confirm/' + selectedOrder.order_code" method="POST">
                                @csrf
                                <button 
                                    type="submit"
                                    :disabled="selectedOrder.status === 'pending_payment'"
                                    :class="selectedOrder.status === 'pending_payment' 
                                        ? 'text-gray-400 cursor-not-allowed' 
                                        : 'text-green-600 hover:underline'"
                                >
                                    ✔ Confirm
                                </button>
                            </form>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </template>
</div>

@endsection

@section('scripts')
<script>
    function notificationPage() {
        return {
            openPopup: false,
            selectedOrder: null,

            showDetail(order) {
                this.selectedOrder = order;
                this.openPopup = true;
            },
            closePopup() {
                this.selectedOrder = null;
                this.openPopup = false;
            },
            formatNumber(nominal) {
                return Number(nominal).toLocaleString('id-ID');
            },
            formatDate(dateString) {
                if (!dateString) return '-';
                const d = new Date(dateString);
                return `${d.getDate().toString().padStart(2, '0')}-${(d.getMonth() + 1).toString().padStart(2, '0')}-${d.getFullYear()} ${d.getHours().toString().padStart(2, '0')}:${d.getMinutes().toString().padStart(2, '0')}`;
            },
            groupedItems() {
                const grouped = {};
                if (!this.selectedOrder?.order_items) return [];
                this.selectedOrder.order_items.forEach(item => {
                    const name = item.product.name;
                    if (!grouped[name]) grouped[name] = { ...item };
                    else grouped[name].quantity += item.quantity;
                });
                return Object.values(grouped);
            }
        };
    }
</script>
@endsection
