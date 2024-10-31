@use('App\Enums\Permission')
@use('App\Enums\Role')
<div class="text-black text-lg"> 

    @role(Role::Admin->value)
    admin role`
    @endrole


    @role(Role::SuperAdmin->value)
        Im a super role
    @endrole

    @role(Role::Capturist->value)
        Capturist
    @endrole
    
    @role(Role::RepairTechnician->value)
        {{ Role::RepairTechnician }}
    @endrole
</div>
