<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Hiển thị danh sách tất cả các cuộc hẹn
     */
    public function index(Request $request)
    {
        $query = Appointment::with(['customer', 'lawyer', 'lawyer.lawyerProfile']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by lawyer
        if ($request->filled('lawyer_id')) {
            $query->where('lawyer_id', $request->lawyer_id);
        }
        
        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
        
        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('customer', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('lawyer', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('appointment_time', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('appointment_time', '<=', $request->end_date);
        }
        
        // Sort
        $sortBy = $request->input('sort_by', 'appointment_time');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        $appointments = $query->paginate(15);
        
        // Get data for filters
        $lawyers = User::where('role', 'lawyer')->with('lawyerProfile')->get();
        $customers = User::where('role', 'customer')->get();
        
        // Get statistics
        $stats = [
            'total' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];
        
        return view('admin.appointments.index', compact(
            'appointments',
            'lawyers',
            'customers',
            'stats'
        ));
    }

    /**
     * Hiển thị chi tiết một cuộc hẹn
     */
    public function show($id)
    {
        $appointment = Appointment::with(['customer', 'lawyer', 'lawyer.lawyerProfile', 'slot'])->findOrFail($id);
        return view('admin.appointments.show', compact('appointment'));
    }

    /**
     * Hiển thị form chỉnh sửa cuộc hẹn
     */
    public function edit($id)
    {
        $appointment = Appointment::with(['customer', 'lawyer'])->findOrFail($id);
        $lawyers = User::where('role', 'lawyer')->with('lawyerProfile')->get();
        $customers = User::where('role', 'customer')->get();
        
        return view('admin.appointments.edit', compact(
            'appointment',
            'lawyers',
            'customers'
        ));
    }

    /**
     * Cập nhật trạng thái hoặc thông tin cuộc hẹn
     */
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'appointment_time' => 'nullable|date_format:Y-m-d H:i',
            'note' => 'nullable|string|max:500',
        ]);
        
        $oldStatus = $appointment->status;
        $appointment->update($validated);
        
        // Tạo notification khi trạng thái thay đổi
        if ($oldStatus !== $validated['status']) {
            $this->createStatusChangeNotifications($appointment, $oldStatus, $validated['status']);
        }
        
        return redirect()->route('admin.appointments.index')
                       ->with('success', 'Cập nhật cuộc hẹn thành công!');
    }

    /**
     * Xác nhận cuộc hẹn
     */
    public function confirm($id)
    {
        $appointment = Appointment::findOrFail($id);
        
        if ($appointment->status === 'pending') {
            $appointment->update(['status' => 'confirmed']);
            
            // Gửi notification
            Notification::create([
                'user_id' => $appointment->customer_id,
                'type' => 'appointment_confirmed',
                'message' => 'Cuộc hẹn của bạn với ' . $appointment->lawyer->name . ' vào lúc ' . $appointment->appointment_time . ' đã được xác nhận.',
            ]);
            
            Notification::create([
                'user_id' => $appointment->lawyer_id,
                'type' => 'appointment_confirmed',
                'message' => 'Cuộc hẹn với ' . $appointment->customer->name . ' vào lúc ' . $appointment->appointment_time . ' đã được xác nhận.',
            ]);
            
            return response()->json(['success' => true, 'message' => 'Xác nhận cuộc hẹn thành công!']);
        }
        
        return response()->json(['success' => false, 'message' => 'Chỉ có thể xác nhận cuộc hẹn đang chờ xử lý!'], 400);
    }

    /**
     * Hủy cuộc hẹn
     */
    public function cancel(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);
        
        if ($appointment->status !== 'cancelled') {
            $oldStatus = $appointment->status;
            $appointment->update([
                'status' => 'cancelled',
                'note' => $validated['reason'] ?? $appointment->note,
            ]);
            
            // Gửi notification
            $reason = $validated['reason'] ?? 'Không có lý do được cung cấp';
            
            Notification::create([
                'user_id' => $appointment->customer_id,
                'type' => 'appointment_cancelled',
                'message' => 'Cuộc hẹn vào lúc ' . $appointment->appointment_time . ' đã bị hủy. Lý do: ' . $reason,
            ]);
            
            Notification::create([
                'user_id' => $appointment->lawyer_id,
                'type' => 'appointment_cancelled',
                'message' => 'Cuộc hẹn vào lúc ' . $appointment->appointment_time . ' đã bị hủy. Lý do: ' . $reason,
            ]);
            
            return redirect()->route('admin.appointments.index')
                           ->with('success', 'Hủy cuộc hẹn thành công!');
        }
        
        return redirect()->route('admin.appointments.index')
                       ->with('error', 'Cuộc hẹn này đã được hủy!');
    }

    /**
     * Xóa cuộc hẹn
     */
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        
        return redirect()->route('admin.appointments.index')
                       ->with('success', 'Xóa cuộc hẹn thành công!');
    }

    /**
     * Lấy dữ liệu thống kê appointments
     */
    public function getStatistics()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        
        return [
            'today_count' => Appointment::whereDate('appointment_time', $today)->count(),
            'today_pending' => Appointment::whereDate('appointment_time', $today)
                                         ->where('status', 'pending')->count(),
            'today_confirmed' => Appointment::whereDate('appointment_time', $today)
                                           ->where('status', 'confirmed')->count(),
            'this_month_count' => Appointment::whereBetween('appointment_time', [$thisMonth, $thisMonth->endOfMonth()])->count(),
            'upcoming' => Appointment::where('appointment_time', '>', now())
                                    ->where('status', '!=', 'cancelled')
                                    ->count(),
            'overdue' => Appointment::where('appointment_time', '<', now())
                                   ->where('status', 'pending')->count(),
        ];
    }

    /**
     * Helper: Tạo notifications khi trạng thái thay đổi
     */
    private function createStatusChangeNotifications($appointment, $oldStatus, $newStatus)
    {
        $statusMessages = [
            'pending' => 'chờ xử lý',
            'confirmed' => 'đã xác nhận',
            'completed' => 'đã hoàn thành',
            'cancelled' => 'đã hủy',
        ];
        
        $message = 'Trạng thái cuộc hẹn đã thay đổi từ ' . $statusMessages[$oldStatus] . ' thành ' . $statusMessages[$newStatus];
        
        Notification::create([
            'user_id' => $appointment->customer_id,
            'type' => 'appointment_status_changed',
            'message' => $message,
        ]);
        
        Notification::create([
            'user_id' => $appointment->lawyer_id,
            'type' => 'appointment_status_changed',
            'message' => $message,
        ]);
    }
}
