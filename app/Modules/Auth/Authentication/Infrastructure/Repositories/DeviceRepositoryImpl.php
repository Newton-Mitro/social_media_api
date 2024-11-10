<?php

namespace App\Modules\Auth\Authentication\Infrastructure\Repositories;

use App\Modules\Auth\Authentication\Domain\Entities\DeviceModel;
use App\Modules\Auth\Authentication\Domain\Interfaces\DeviceRepositoryInterface;
use App\Modules\Auth\Authentication\Infrastructure\Mappers\DeviceMapper;
use App\Modules\Auth\Authentication\Infrastructure\Models\Device;
use Exception;
use Illuminate\Http\Response;

class DeviceRepositoryImpl implements DeviceRepositoryInterface
{
    public function findDeviceByUserIdAndDeviceName(string $user_id, string $device_name): ?DeviceModel
    {
        $device = Device::where('user_id', $user_id)->where('device_name', $device_name)->first();
        if ($device) {
            return DeviceMapper::toBusinessModel($device);
        }

        return null;
    }

    public function findDeviceWithToken(string $device_token): ?DeviceModel
    {
        $device = Device::where('device_token', $device_token)->first();
        if ($device) {
            return DeviceMapper::toBusinessModel($device);
        }

        return null;
    }

    public function create(DeviceModel $model): DeviceModel
    {
        try {
            $device = new Device;
            $device->user_id = $model->getUserId();
            $device->device_name = $model->getDeviceName();
            $device->device_ip = $model->getDeviceIp();
            $device->device_identifier = $model->getDeviceIdentifier();
            $device->device_token = $model->getDeviceToken();
            $device->created_at = $model->getCreatedAt();
            $device->updated_at = $model->getUpdatedAt();
            $device->save();

            return DeviceMapper::toBusinessModel($device);
        } catch (Exception) {
            throw new Exception('Failed to create device', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(int $deviceId, DeviceModel $model): DeviceModel
    {
        try {
            $device = Device::find($deviceId);
            $device->user_id = $model->getUserId();
            $device->device_name = $model->getDeviceName();
            $device->device_ip = $model->getDeviceIp();
            $device->device_identifier = $model->getDeviceIdentifier();
            $device->device_token = $model->getDeviceToken();
            $device->created_at = $model->getCreatedAt();
            $device->updated_at = $model->getUpdatedAt();
            $device->save();

            return DeviceMapper::toBusinessModel($device);
        } catch (Exception) {
            throw new Exception('Failed to update device', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logoutFromAllDevices(string $user_id): void
    {
        try {
            Device::where('user_id', $user_id)->delete();
        } catch (Exception) {
            throw new Exception('Failed to delete device', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function findUserDevices(string $user_id): array
    {
        return Device::where('user_id', $user_id)->get();
    }
}
