/* Change delimiter in phpmyadmin to // */

DROP TRIGGER IF EXISTS ChangeStatusOfPetTrigger//
create trigger ChangeStatusOfPetTrigger
   BEFORE UPDATE ON Pets
   FOR EACH ROW 
begin
   if(new.active != old.active) then
   insert into ChangeStatusOfPet(id)
   values(old.petId);
   end if;
END; //


DROP TRIGGER IF EXISTS ChangeStatusOfPolicyTrigger//
create trigger ChangeStatusOfPolicyTrigger
   BEFORE UPDATE ON Policies
   FOR EACH ROW 
begin
   if(new.active != old.active) then
   insert into ChangeStatusOfPolicy(id)
   values(old.policyId);
   end if;
END; //

DROP TRIGGER IF EXISTS ChangeStatusOfUsersTrigger//
create trigger ChangeStatusOfUsersTrigger
   BEFORE UPDATE ON Users
   FOR EACH ROW 
begin
   if(new.active != old.active) then
   insert into ChangeStatusOfUser(id)
   values(old.userId);
   end if;
END; //

DROP TRIGGER IF EXISTS ChangeStatusOfBillTrigger//
create trigger ChangeStatusOfBillTrigger
   BEFORE UPDATE ON Bills
   FOR EACH ROW 
begin
   if(new.status != old.status) then
   insert into ChangeStatusOfBill(id)
   values(old.billId);
   end if;
END; //
