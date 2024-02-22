using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
public class PlayerUI : MonoBehaviour
{
    [SerializeField] private Text nameText;

    //  Slot関数  //
    public Sprite blankImage;
    public List<Sprite> imageList = new List<Sprite>();
    public List<Image> slotList = new List<Image>();
    public Text slotName;
    private int imageCount;
    private int selectCount;
    private int itemNumber;
    // Start is called before the first frame update
    void Start()
    {
        
    }

    // Update is called once per frame
    void Update()
    {
        KeyHandler();
    }
    public void KeyHandler()  //キー入力関数
    {
        //Slot関数//
        if (Input.GetKeyDown(KeyCode.E))
        {
            selectCount += 1;
            if (selectCount > imageList.Count)
            {
                selectCount = 1;
            }
            Slot();
        }
        else if (Input.GetKeyDown(KeyCode.Q))
        {
            selectCount -= 1;
            if (selectCount < -imageList.Count)
            {
                selectCount = -1;
            }
            Slot();
        }
    }
    public void Slot()  //アイテムスロット関数
    {
        for (int i = 0; i < slotList.Count; i++)
        {
            itemNumber = i + selectCount;
            if (imageList.Count > 2)
            {
                //itemNumberが画像の数より多かった場合
                if (itemNumber > imageList.Count - 1)
                {
                    int result = itemNumber - imageList.Count;
                    itemNumber = result;
                }
                //itemNumberが0より小さかった場合
                if (itemNumber < 0)
                {
                    int result = imageList.Count + itemNumber;
                    itemNumber = result;
                }

            }
            //slotList[i].sprite = itemList[itemNumber].GetComponent<ItemController>().image;
            slotList[i].sprite = imageList[itemNumber];
            if (slotList[0].sprite.name == "Blank") slotName.text = null;
            else slotName.text = slotList[0].sprite.name;

        }
    }
    public void ObjectName(GameObject target)
    {
        nameText.text = target.name;
        Debug.Log("OK");
        if (Input.GetMouseButtonDown(0))
        {
            if(target.tag == "Battery" || target.tag == "Key")
            {
                Destroy(target);
            }
        }
    }
}
