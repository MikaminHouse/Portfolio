using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class Knob : MonoBehaviour
{
    public DoorController doorController;
    public LockController lockController;
    public GameObject search_F;  //•\ƒhƒAƒmƒu‚ðŠi”[
    public GameObject search_B;  //— ƒhƒAƒmƒu‚ðŠi”[

    // Start is called before the first frame update
    void Start()
    {
        
    }

    // Update is called once per frame
    void Update()
    {
    }
    private void OnTriggerStay(Collider other)
    {
        if ((other.tag == "Player" || other.tag == "Enemy") && search_F)
        {
            if(doorController) doorController.canF = true;
            if(lockController) lockController.canF = true;

        }
        if ((other.tag == "Player" || other.tag == "Enemy") && search_B)
        {
            if(doorController) doorController.canB = true;
            if(lockController) lockController.canB = true;
        }

    }
    private void OnTriggerExit(Collider other)
    {
        if (doorController)
        {
            doorController.canF = false;
            doorController.canB = false;
        }
        else if (lockController)
        {
            lockController.canF = false;
            lockController.canB = false;
        }
    }
}
